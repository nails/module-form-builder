<?php

/**
 * Migration:   3
 * Started:     13/02/2017
 * Finalised:   13/02/2017
 *
 * @package     Nails
 * @subpackage  module-form-builder
 * @category    Database Migration
 * @author      Nails Dev Team
 * @link
 */

namespace Nails\Database\Migration\Nailsapp\ModuleFormBuilder;

use Nails\Common\Console\Migrate\Base;

class Migration3 extends Base
{
    /**
     * Execute the migration
     * @return Void
     */
    public function execute()
    {
        $this->query("ALTER TABLE `{{NAILS_DB_PREFIX}}formbuilder_form_field_option` DROP FOREIGN KEY `{{NAILS_DB_PREFIX}}formbuilder_field_option_ibfk_3`;");
        $this->query("ALTER TABLE `{{NAILS_DB_PREFIX}}formbuilder_form_field_option` ADD FOREIGN KEY (`modified_by`) REFERENCES `advice` (`id`) ON DELETE SET NULL;");
    }
}
