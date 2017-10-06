<?php

/**
 * Manage form fields
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

class FormField extends Base
{
    /**
     * Construct the model
     */
    public function __construct()
    {
        parent::__construct();

        $this->table             = NAILS_DB_PREFIX . 'formbuilder_form_field';
        $this->tableAlias        = 'ff';
        $this->defaultSortColumn = 'order';
    }

    // --------------------------------------------------------------------------

    /**
     * Returns all field objects
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
            $this->getManyAssociatedItems(
                $aItems,
                'options',
                'form_field_id',
                'FormFieldOption',
                'nailsapp/module-form-builder'
            );
        }

        return $aItems;
    }

    // --------------------------------------------------------------------------

    /**
     * Formats a single object
     *
     * The getAll() method iterates over each returned item with this method so as to
     * correctly format the output. Use this to cast integers and booleans and/or organise data into objects.
     *
     * @param  object $oObj      A reference to the object being formatted.
     * @param  array  $aData     The same data array which is passed to getCountCommon, for reference if needed
     * @param  array  $aIntegers Fields which should be cast as integers if numerical and not null
     * @param  array  $aBools    Fields which should be cast as booleans if not null
     * @param  array  $aFloats   Fields which should be cast as floats if not null
     *
     * @return void
     */
    protected function formatObject(
        &$oObj,
        $aData = [],
        $aIntegers = [],
        $aBools = [],
        $aFloats = []
    ) {

        $aIntegers[] = 'form_id';
        $aBools[]    = 'is_required';

        parent::formatObject($oObj, $aData, $aIntegers, $aBools, $aFloats);
    }

    // --------------------------------------------------------------------------

    /**
     * Creates a new field
     *
     * @param array   $aData         The data to create the object with
     * @param boolean $bReturnObject Whether to return just the new ID or the full object
     *
     * @return mixed
     */
    public function create($aData = [], $bReturnObject = false)
    {
        $aOptions = array_key_exists('options', $aData) ? $aData['options'] : [];
        unset($aData['options']);

        try {

            $oDb = Factory::service('Database');

            $oDb->trans_begin();
            $mResult = parent::create($aData, $bReturnObject);

            if ($mResult) {

                $iFormFieldId = $bReturnObject ? $mResult->id : $mResult;
                $bResult      = $this->saveAssociatedItems(
                    $iFormFieldId,
                    $aOptions,
                    'form_field_id',
                    'FormFieldOption',
                    'nailsapp/module-form-builder'
                );

                if (!$bResult) {
                    throw new \Exception('Failed to update options.', 1);
                }

            } else {
                throw new \Exception('Failed to create field. ' . $this->lastError(), 1);
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
     * Update an existing field
     *
     * @param int   $iId   The ID of the field to update
     * @param array $aData The data to update the field with
     *
     * @return mixed
     */
    public function update($iId, $aData = [])
    {
        $aOptions = array_key_exists('options', $aData) ? $aData['options'] : [];
        unset($aData['options']);

        try {

            $oDb = Factory::service('Database');

            $oDb->trans_begin();

            if (parent::update($iId, $aData)) {
                $bResult = $this->saveAssociatedItems(
                    $iId,
                    $aOptions,
                    'form_field_id',
                    'FormFieldOption',
                    'nailsapp/module-form-builder'
                );
                if (!$bResult) {
                    throw new \Exception('Failed to update field options.', 1);
                }
            } else {
                throw new \Exception('Failed to update field. ' . $this->lastError(), 1);
            }

            $oDb->trans_commit();
            return true;

        } catch (\Exception $e) {

            $oDb->trans_rollback();
            $this->setError($e->getMessage());
            return false;
        }
    }
}
