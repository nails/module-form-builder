<?php

/**
 * Migration:   5
 * Started:     01/03/2021
 *
 * @package     Nails
 * @subpackage  module-form-builder
 * @category    Database Migration
 * @author      Nails Dev Team
 */

namespace Nails\FormBuilder\Database\Migration;

use Nails\Common\Console\Migrate\Base;

/**
 * Class Migration5
 *
 * @package Nails\Database\Migration\Nails\ModuleFormBuilder
 */
class Migration5 extends Base
{
    /**
     * Execute the migration
     * @return Void
     */
    public function execute()
    {
        $this->query('UPDATE `{{NAILS_DB_PREFIX}}formbuilder_form_field` SET `default_value` = "\\\\Nails\\\\Auth\\\\FormBuilder\\\\DefaultValue\\\\User\\\\Email" WHERE `default_value` = "\\\\Nails\\\\FormBuilder\\\\FormBuilder\\\\DefaultValue\\\\UserEmail";');
        $this->query('UPDATE `{{NAILS_DB_PREFIX}}formbuilder_form_field` SET `default_value` = "\\\\Nails\\\\Auth\\\\FormBuilder\\\\DefaultValue\\\\User\\\\FirstName" WHERE `default_value` = "\\\\Nails\\\\FormBuilder\\\\FormBuilder\\\\DefaultValue\\\\UserFirstName";');
        $this->query('UPDATE `{{NAILS_DB_PREFIX}}formbuilder_form_field` SET `default_value` = "\\\\Nails\\\\Auth\\\\FormBuilder\\\\DefaultValue\\\\User\\\\Id" WHERE `default_value` = "\\\\Nails\\\\FormBuilder\\\\FormBuilder\\\\DefaultValue\\\\UserId";');
        $this->query('UPDATE `{{NAILS_DB_PREFIX}}formbuilder_form_field` SET `default_value` = "\\\\Nails\\\\Auth\\\\FormBuilder\\\\DefaultValue\\\\User\\\\LastName" WHERE `default_value` = "\\\\Nails\\\\FormBuilder\\\\FormBuilder\\\\DefaultValue\\\\UserLastName";');
        $this->query('UPDATE `{{NAILS_DB_PREFIX}}formbuilder_form_field` SET `default_value` = "\\\\Nails\\\\Auth\\\\FormBuilder\\\\DefaultValue\\\\User\\\\Name" WHERE `default_value` = "\\\\Nails\\\\FormBuilder\\\\FormBuilder\\\\DefaultValue\\\\UserName";');
    }
}
