<?php

/**
 * Migration:   0
 * Started:     18/04/2016
 * Finalised:
 *
 * @package     Nails
 * @subpackage  module-form-builder
 * @category    Database Migration
 * @author      Nails Dev Team
 * @link
 */

namespace Nails\Database\Migration\Nails\ModuleFormBuilder;

use Nails\Common\Console\Migrate\Base;

class Migration0 extends Base
{
    /**
     * Execute the migration
     * @return Void
     */
    public function execute()
    {
        $this->query("
            CREATE TABLE `{{NAILS_DB_PREFIX}}formbuilder_form` (
                `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `is_deleted` tinyint(1) unsigned NOT NULL DEFAULT '0',
                `created` datetime NOT NULL,
                `created_by` int(11) unsigned DEFAULT NULL,
                `modified` datetime NOT NULL,
                `modified_by` int(11) unsigned DEFAULT NULL,
                PRIMARY KEY (`id`),
                KEY `created_by` (`created_by`),
                KEY `modified_by` (`modified_by`),
                CONSTRAINT `{{NAILS_DB_PREFIX}}formbuilder_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `{{NAILS_DB_PREFIX}}user` (`id`) ON DELETE SET NULL,
                CONSTRAINT `{{NAILS_DB_PREFIX}}formbuilder_ibfk_2` FOREIGN KEY (`modified_by`) REFERENCES `{{NAILS_DB_PREFIX}}user` (`id`) ON DELETE SET NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
        $this->query("
            CREATE TABLE `{{NAILS_DB_PREFIX}}formbuilder_form_field` (
                `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `form_id` int(11) unsigned NOT NULL,
                `type` varchar(255) NOT NULL DEFAULT 'TEXT',
                `label` varchar(150) NOT NULL DEFAULT '',
                `sub_label` varchar(255) NOT NULL DEFAULT '',
                `placeholder` varchar(255) NOT NULL DEFAULT '',
                `is_required` tinyint(1) unsigned NOT NULL DEFAULT '0',
                `default_value` varchar(255) DEFAULT 'NONE',
                `custom_attributes` text NOT NULL,
                `order` int(11) unsigned NOT NULL DEFAULT '0',
                `is_deleted` tinyint(1) unsigned NOT NULL DEFAULT '0',
                `created` datetime NOT NULL,
                `created_by` int(11) unsigned DEFAULT NULL,
                `modified` datetime NOT NULL,
                `modified_by` int(11) unsigned DEFAULT NULL,
                PRIMARY KEY (`id`),
                KEY `form_id` (`form_id`),
                KEY `created_by` (`created_by`),
                KEY `modified_by` (`modified_by`),
                CONSTRAINT `{{NAILS_DB_PREFIX}}formbuilder_field_ibfk_1` FOREIGN KEY (`form_id`) REFERENCES `{{NAILS_DB_PREFIX}}formbuilder_form` (`id`) ON DELETE CASCADE,
                CONSTRAINT `{{NAILS_DB_PREFIX}}formbuilder_field_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `{{NAILS_DB_PREFIX}}user` (`id`) ON DELETE SET NULL,
                CONSTRAINT `{{NAILS_DB_PREFIX}}formbuilder_field_ibfk_3` FOREIGN KEY (`modified_by`) REFERENCES `{{NAILS_DB_PREFIX}}user` (`id`) ON DELETE SET NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
        $this->query("
            CREATE TABLE `{{NAILS_DB_PREFIX}}formbuilder_form_field_option` (
                `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `form_field_id` int(11) unsigned NOT NULL,
                `label` varchar(255) NOT NULL DEFAULT '',
                `is_disabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
                `is_selected` tinyint(1) unsigned NOT NULL DEFAULT '0',
                `order` int(11) unsigned NOT NULL DEFAULT '0',
                `is_deleted` tinyint(1) unsigned NOT NULL DEFAULT '0',
                `created` datetime NOT NULL,
                `created_by` int(11) unsigned DEFAULT NULL,
                `modified` datetime NOT NULL,
                `modified_by` int(11) unsigned DEFAULT NULL,
                PRIMARY KEY (`id`),
                KEY `form_item_id` (`form_field_id`),
                KEY `created_by` (`created_by`),
                KEY `modified_by` (`modified_by`),
                CONSTRAINT `{{NAILS_DB_PREFIX}}formbuilder_field_option_ibfk_1` FOREIGN KEY (`form_field_id`) REFERENCES `{{NAILS_DB_PREFIX}}formbuilder_form_field` (`id`) ON DELETE CASCADE,
                CONSTRAINT `{{NAILS_DB_PREFIX}}formbuilder_field_option_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `{{NAILS_DB_PREFIX}}user` (`id`) ON DELETE SET NULL,
                CONSTRAINT `{{NAILS_DB_PREFIX}}formbuilder_field_option_ibfk_3` FOREIGN KEY (`modified_by`) REFERENCES `{{NAILS_DB_PREFIX}}user` (`id`) ON UPDATE SET NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
    }
}
