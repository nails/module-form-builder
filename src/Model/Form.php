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

use Nails\Common\Exception\ModelException;
use Nails\Common\Exception\NailsException;
use Nails\Common\Model\Base;
use Nails\Factory;
use Nails\FormBuilder\Constants;

/**
 * Class Form
 *
 * @package Nails\FormBuilder\Model
 */
class Form extends Base
{
    const TABLE             = NAILS_DB_PREFIX . 'formbuilder_form';
    const RESOURCE_NAME     = 'Form';
    const RESOURCE_PROVIDER = Constants::MODULE_SLUG;

    // --------------------------------------------------------------------------

    /**
     * The name of the "label" column
     *
     * @var string
     */
    protected $tableLabelColumn = null;

    /**
     * The name of the "slug" column
     *
     * @var string
     */
    protected $tableSlugColumn = null;

    // --------------------------------------------------------------------------

    /**
     * Form constructor.
     *
     * @throws ModelException
     */
    public function __construct()
    {
        parent::__construct();
        $this->hasMany('fields', 'FormField', 'form_id', Constants::MODULE_SLUG);
    }

    // --------------------------------------------------------------------------

    /**
     * Creates a new copy of an existing form
     *
     * @param integer $iFormId       The ID of the form to duplicate
     * @param boolean $bReturnObject Whether to return the entire new form object, or just the ID
     * @param array   $aReturnData   An array to pass to the getById() call when $bReturnObject is true
     *
     * @return mixed
     */
    public function copy($iFormId, $bReturnObject = false, $aReturnData = [])
    {
        $oDb = Factory::service('Database');

        try {

            //  Begin the transaction
            $oDb->transaction()->start();

            //  Check form exists
            $oForm = $this->getById($iFormId);

            if (empty($oForm)) {
                throw new NailsException('Not a valid form ID.', 1);
            }

            //  Duplicate the form, fields and options
            $oFormFieldModel       = Factory::model('FormField', Constants::MODULE_SLUG);
            $oFormFieldOptionModel = Factory::model('FormFieldOption', Constants::MODULE_SLUG);

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
                        $aRow['form_field_id']              = $iNewFieldId;
                        $aRow[$this->getColumnCreated()]    = $sNow;
                        $aRow[$this->getColumnCreatedBy()]  = activeUser('id') ?: null;
                        $aRow[$this->getColumnModified()]   = $sNow;
                        $aRow[$this->getColumnModifiedBy()] = activeUser('id') ?: null;
                    }
                    unset($aRow);
                    if (!$oDb->insert_batch($sTableOptions, $aFormOptionRows)) {
                        throw new NailsException('Failed to copy form field option records.', 1);
                    }
                }
            }

            //  All done
            $oDb->transaction()->commit();

            //  Return the new form's ID or object
            return $bReturnObject ? $this->getById($iNewFormId, $aReturnData) : $iNewFormId;

        } catch (\Exception $e) {

            $oDb->transaction()->rollback();
            $this->setError($e->getMessage());

            return false;
        }
    }
}
