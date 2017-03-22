<?php

/**
 * Migration:   4
 * Started:     22/03/2017
 * Finalised:   22/03/2017
 *
 * @package     Nails
 * @subpackage  module-form-builder
 * @category    Database Migration
 * @author      Nails Dev Team
 * @link
 */

namespace Nails\Database\Migration\Nailsapp\ModuleFormBuilder;

use Nails\Common\Console\Migrate\Base;

class Migration4 extends Base
{
    /**
     * Execute the migration
     * @return Void
     */
    public function execute()
    {
        $this->query("ALTER TABLE `{{NAILS_DB_PREFIX}}formbuilder_form` DROP FOREIGN KEY `{{NAILS_DB_PREFIX}}formbuilder_ibfk_1`;");
        $this->query("ALTER TABLE `{{NAILS_DB_PREFIX}}formbuilder_form` DROP FOREIGN KEY `{{NAILS_DB_PREFIX}}formbuilder_ibfk_2`;");
        $this->query("ALTER TABLE `{{NAILS_DB_PREFIX}}formbuilder_form` ADD FOREIGN KEY (`created_by`) REFERENCES `{{NAILS_DB_PREFIX}}user` (`id`) ON DELETE SET NULL;");
        $this->query("ALTER TABLE `{{NAILS_DB_PREFIX}}formbuilder_form` ADD FOREIGN KEY (`modified_by`) REFERENCES `{{NAILS_DB_PREFIX}}user` (`id`) ON DELETE SET NULL;");
        $this->query("ALTER TABLE `{{NAILS_DB_PREFIX}}formbuilder_form_field` DROP FOREIGN KEY `{{NAILS_DB_PREFIX}}formbuilder_field_ibfk_1`;");
        $this->query("ALTER TABLE `{{NAILS_DB_PREFIX}}formbuilder_form_field` DROP FOREIGN KEY `{{NAILS_DB_PREFIX}}formbuilder_field_ibfk_2`;");
        $this->query("ALTER TABLE `{{NAILS_DB_PREFIX}}formbuilder_form_field` DROP FOREIGN KEY `{{NAILS_DB_PREFIX}}formbuilder_field_ibfk_3`;");
        $this->query("ALTER TABLE `{{NAILS_DB_PREFIX}}formbuilder_form_field` ADD FOREIGN KEY (`created_by`) REFERENCES `{{NAILS_DB_PREFIX}}user` (`id`) ON DELETE SET NULL;");
        $this->query("ALTER TABLE `{{NAILS_DB_PREFIX}}formbuilder_form_field` ADD FOREIGN KEY (`modified_by`) REFERENCES `{{NAILS_DB_PREFIX}}user` (`id`) ON DELETE SET NULL;");
        $this->query("ALTER TABLE `{{NAILS_DB_PREFIX}}formbuilder_form_field` ADD FOREIGN KEY (`form_id`) REFERENCES `{{NAILS_DB_PREFIX}}formbuilder_form` (`id`) ON DELETE CASCADE;");
        $this->query("ALTER TABLE `{{NAILS_DB_PREFIX}}formbuilder_form_field_option` DROP FOREIGN KEY `{{NAILS_DB_PREFIX}}formbuilder_field_option_ibfk_1`;");
        $this->query("ALTER TABLE `{{NAILS_DB_PREFIX}}formbuilder_form_field_option` DROP FOREIGN KEY `{{NAILS_DB_PREFIX}}formbuilder_field_option_ibfk_2`;");
        $this->query("ALTER TABLE `{{NAILS_DB_PREFIX}}formbuilder_form_field_option` DROP FOREIGN KEY `{{NAILS_DB_PREFIX}}formbuilder_form_field_option_ibfk_1`;");
        $this->query("ALTER TABLE `{{NAILS_DB_PREFIX}}formbuilder_form_field_option` ADD FOREIGN KEY (`created_by`) REFERENCES `{{NAILS_DB_PREFIX}}user` (`id`) ON DELETE SET NULL;");
        $this->query("ALTER TABLE `{{NAILS_DB_PREFIX}}formbuilder_form_field_option` ADD FOREIGN KEY (`modified_by`) REFERENCES `{{NAILS_DB_PREFIX}}user` (`id`) ON DELETE SET NULL;");
        $this->query("ALTER TABLE `{{NAILS_DB_PREFIX}}formbuilder_form_field_option` ADD FOREIGN KEY (`form_field_id`) REFERENCES `{{NAILS_DB_PREFIX}}formbuilder_form_field` (`id`) ON DELETE CASCADE;");
    }
}
