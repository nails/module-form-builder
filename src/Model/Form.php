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

use Nails\Factory;
use Nails\Common\Model\Base;

class Form extends Base
{
    /**
     * Construct the model
     */
    public function __construct()
    {
        parent::__construct();
        $this->table             = NAILS_DB_PREFIX . 'formbuilder_form';
        $this->tablePrefix       = 'fbf';
        $this->tableSlugColumn   = null;
        $this->tableLabelColumn  = null;
        $this->defaultSortColumn = null;
    }

    // --------------------------------------------------------------------------

    /**
     * Returns all form objects
     * @param null    $iPage            The page to return
     * @param null    $iPerPage         The number of objects per page
     * @param array   $aData            Data to pass to _getcount_common
     * @param boolean $bIncludeDeleted  Whether to include deleted results
     * @return array
     */
    public function getAll($iPage = null, $iPerPage = null, $aData = array(), $bIncludeDeleted = false)
    {
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
     * @param array   $aData         The data to create the object with
     * @param boolean $bReturnObject Whether to return just the new ID or the full object
     * @return mixed
     */
    public function create($aData = array(), $bReturnObject = false)
    {
        $aFields = array_key_exists('fields', $aData) ? $aData['fields'] : array();
        unset($aData['fields']);

        try {

            $oDb = Factory::service('Database');

            $oDb->trans_begin();

            $mResult = parent::create($aData, $bReturnObject);

            if ($mResult) {

                $iFormId = $bReturnObject ? $mResult->id : $mResult;
                $bResult = $this->saveAsscociatedItems(
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
     * @param int   $iId   The ID of the form to update
     * @param array $aData The data to update the form with
     * @return mixed
     */
    public function update($iId, $aData = array())
    {
        $aFields = array_key_exists('fields', $aData) ? $aData['fields'] : array();
        unset($aData['fields']);

        try {

            $oDb = Factory::service('Database');

            $oDb->trans_begin();

            if (parent::update($iId, $aData)) {

                $bResult = $this->saveAsscociatedItems(
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
}
