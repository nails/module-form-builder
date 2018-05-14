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

use Nails\Common\Model\Base;
use Nails\Factory;

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
    }

    // --------------------------------------------------------------------------

    /**
     * Returns all form objects
     *
     * @param null    $iPage           The page to return
     * @param null    $iPerPage        The number of objects per page
     * @param array   $aData           Data to pass to getCountCommon
     * @param boolean $bIncludeDeleted Whether to include deleted results
     *
     * @return array
     */
    public function getAll($iPage = null, $iPerPage = null, $aData = [], $bIncludeDeleted = false)
    {
        //  If the first value is an array then treat as if called with getAll(null, null, $aData);
        //  @todo (Pablo - 2017-10-06) - Convert these to expandable fields
        if (is_array($iPage)) {
            $aData = $iPage;
            $iPage = null;
        }

        $aItems = parent::getAll($iPage, $iPerPage, $aData, $bIncludeDeleted);

        if (!empty($aItems)) {
            if (!empty($aData['includeAll']) || !empty($aData['includeFields'])) {
                $this->getManyAssociatedItems(
                    $aItems,
                    'fields',
                    'form_id',
                    'FormField',
                    'nailsapp/module-form-builder'
                );
            }
        }

        return $aItems;
    }

    // --------------------------------------------------------------------------

    /**
     * Creates a new form
     *
     * @param array   $aData         The data to create the object with
     * @param boolean $bReturnObject Whether to return just the new ID or the full object
     *
     * @return mixed
     */
    public function create($aData = [], $bReturnObject = false)
    {
        $aFields = array_key_exists('fields', $aData) ? $aData['fields'] : [];
        unset($aData['fields']);

        $oDb = Factory::service('Database');

        try {

            $oDb->trans_begin();

            $mResult = parent::create($aData, $bReturnObject);

            if ($mResult) {

                $iFormId = $bReturnObject ? $mResult->id : $mResult;
                $bResult = $this->saveAssociatedItems(
                    $iFormId,
                    $aFields,
                    'form_id',
                    'FormField',
                    'nailsapp/module-form-builder'
                );

                if (!$bResult) {
                    throw new \Exception('Failed to update fields.', 1);
                }

            } else {
                throw new \Exception('Failed to create form. ' . $this->lastError(), 1);
            }

            $oDb->trans_commit();

            return $mResult;

        } catch (\Exception $e) {

            $oDb->trans_rollback();
            $this->setError($e->getMessage());

            return false;
        }
    }

    // --------------------------------------------------------------------------

    /**
     * Update an existing form
     *
     * @param int   $iId   The ID of the form to update
     * @param array $aData The data to update the form with
     *
     * @return mixed
     */
    public function update($iId, $aData = [])
    {
        $aFields = array_key_exists('fields', $aData) ? $aData['fields'] : [];
        unset($aData['fields']);

        $oDb = Factory::service('Database');

        try {

            $oDb->trans_begin();

            if (parent::update($iId, $aData)) {

                $bResult = $this->saveAssociatedItems(
                    $iId,
                    $aFields,
                    'form_id',
                    'FormField',
                    'nailsapp/module-form-builder'
                );

                if (!$bResult) {
                    throw new \Exception('Failed to update fields.', 1);
                }
            } else {
                throw new \Exception('Failed to update form. ' . $this->lastError(), 1);
            }

            $oDb->trans_commit();

            return true;

        } catch (\Exception $e) {

            $oDb->trans_rollback();
            $this->setError($e->getMessage());

            return false;
        }
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
            $oForm = $this->getById($iFormId, ['includeAll' => true]);

            if (empty($oForm)) {
                throw new \Exception('Not a valid form ID.', 1);
            }

            //  Duplicate the form, fields and options
            $oFormFieldModel       = Factory::model('FormField', 'nailsapp/module-form-builder');
            $oFormFieldOptionModel = Factory::model('FormFieldOption', 'nailsapp/module-form-builder');

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
                throw new \Exception('Failed to copy parent form record.', 1);
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
                    throw new \Exception('Failed to copy form field record.', 1);
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
                        throw new \Exception('Failed to copy form field option records.', 1);
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
        $aData = [],
        $aIntegers = [],
        $aBools = [],
        $aFloats = []
    ) {

        $aBools[] = 'has_captcha';

        parent::formatObject($oObj, $aData, $aIntegers, $aBools, $aFloats);
    }
}
