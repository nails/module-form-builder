<?php

/**
 * Manage forms
 *
 * @package     Nails
 * @subpackage  module-form-builder
 * @category    Model
 * @author      Nails Dev Team
 * @link
 */

namespace Nails\FormBuilder\Model;

use Nails\Common\Exception\NailsException;
use Nails\Common\Model\Base;
use Nails\Factory;

/**
 * Class Form
 *
 * @package Nails\FormBuilder\Model
 */
class Form extends Base
{
    /**
     * Construct the model
     */
    public function __construct()
    {
        parent::__construct();
        $this->table             = NAILS_DB_PREFIX . 'formbuilder_form';
        $this->tableSlugColumn   = null;
        $this->tableLabelColumn  = null;
        $this->defaultSortColumn = null;
        $this->addExpandableField([
            'trigger'   => 'fields',
            'type'      => self::EXPANDABLE_TYPE_MANY,
            'property'  => 'fields',
            'model'     => 'FormField',
            'provider'  => 'nails/module-form-builder',
            'id_column' => 'form_id',
        ]);
    }

    // --------------------------------------------------------------------------

    /**
     * Creates a new copy of an existing form
     *
     * @param  integer $iFormId       The ID of the form to duplicate
     * @param  boolean $bReturnObject Whether to return the entire new form object, or just the ID
     * @param  array   $aReturnData   An array to pass to the getById() call when $bReturnObject is true
     *
     * @return mixed
     */
    public function copy($iFormId, $bReturnObject = false, $aReturnData = [])
    {
        $oDb = Factory::service('Database');

        try {

            //  Begin the transaction
            $oDb->trans_begin();

            //  Check form exists
            $oForm = $this->getById($iFormId);

            if (empty($oForm)) {
                throw new NailsException('Not a valid form ID.', 1);
            }

            //  Duplicate the form, fields and options
            $oFormFieldModel       = Factory::model('FormField', 'nails/module-form-builder');
            $oFormFieldOptionModel = Factory::model('FormFieldOption', 'nails/module-form-builder');

            $sTableForm    = $this->getTableName();
            $sTableFields  = $oFormFieldModel->getTableName();
            $sTableOptions = $oFormFieldOptionModel->getTableName();

            $oNow = Factory::factory('DateTime');
            $sNow = $oNow->format('Y-m-d H:i:s');

            //  Form
            $oDb->where('id', $oForm->id);
            $oFormRow = $oDb->get($sTableForm)->row();

            unset($oFormRow->id);
            $oFormRow->created     = $sNow;
            $oFormRow->created_by  = activeUser('id') ?: null;
            $oFormRow->modified    = $sNow;
            $oFormRow->modified_by = activeUser('id') ?: null;

            $oDb->set($oFormRow);
            if (!$oDb->insert($sTableForm)) {
                throw new NailsException('Failed to copy parent form record.', 1);
            }

            $iNewFormId = $oDb->insert_id();

            //  Fields
            $oDb->where_in('form_id', $oForm->id);
            $aFormFieldRows = $oDb->get($sTableFields)->result();
            foreach ($aFormFieldRows as $oRow) {

                $iOldFieldId = $oRow->id;
                unset($oRow->id);
                $oRow->form_id     = $iNewFormId;
                $oRow->created     = $sNow;
                $oRow->created_by  = activeUser('id') ?: null;
                $oRow->modified    = $sNow;
                $oRow->modified_by = activeUser('id') ?: null;

                $oDb->set($oRow);
                if (!$oDb->insert($sTableFields)) {
                    throw new NailsException('Failed to copy form field record.', 1);
                }

                $iNewFieldId = $oDb->insert_id();

                //  Options
                $oDb->where('form_field_id', $iOldFieldId);
                $aFormOptionRows = $oDb->get($sTableOptions)->result_array();
                if (!empty($aFormOptionRows)) {
                    foreach ($aFormOptionRows as &$aRow) {
                        unset($aRow['id']);
                        $aRow['form_field_id'] = $iNewFieldId;
                        $aRow['created']       = $sNow;
                        $aRow['created_by']    = activeUser('id') ?: null;
                        $aRow['modified']      = $sNow;
                        $aRow['modified_by']   = activeUser('id') ?: null;
                    }
                    unset($aRow);
                    if (!$oDb->insert_batch($sTableOptions, $aFormOptionRows)) {
                        throw new NailsException('Failed to copy form field option records.', 1);
                    }
                }
            }

            //  All done
            $oDb->trans_commit();

            //  Return the new form's ID or object
            return $bReturnObject ? $this->getById($iNewFormId, $aReturnData) : $iNewFormId;

        } catch (\Exception $e) {

            $oDb->trans_rollback();
            $this->setError($e->getMessage());

            return false;
        }
    }

    // --------------------------------------------------------------------------

    protected function formatObject(
        &$oObj,
        array $aData = [],
        array $aIntegers = [],
        array $aBools = [],
        array $aFloats = []
    ) {

        $aBools[] = 'has_captcha';

        parent::formatObject($oObj, $aData, $aIntegers, $aBools, $aFloats);
    }
}
