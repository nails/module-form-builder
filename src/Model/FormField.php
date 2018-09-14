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

class FormField extends Base
{
    /**
     * Construct the model
     */
    public function __construct()
    {
        parent::__construct();
        $this->table             = NAILS_DB_PREFIX . 'formbuilder_form_field';
        $this->defaultSortColumn = 'order';
        $this->addExpandableField([
            'trigger'   => 'options',
            'type'      => self::EXPANDABLE_TYPE_MANY,
            'property'  => 'options',
            'model'     => 'FormFieldOption',
            'provider'  => 'nails/module-form-builder',
            'id_column' => 'form_field_id',
        ]);
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
        array $aData = [],
        array $aIntegers = [],
        array $aBools = [],
        array $aFloats = []
    ) {
        $aIntegers[] = 'form_id';
        $aBools[]    = 'is_required';
        parent::formatObject($oObj, $aData, $aIntegers, $aBools, $aFloats);
    }
}
