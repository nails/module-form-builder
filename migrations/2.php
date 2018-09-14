<?php

/**
 * Migration:   2
 * Started:     09/06/2016
 * Finalised:   09/06/2016
 *
 * @package     Nails
 * @subpackage  module-form-builder
 * @category    Database Migration
 * @author      Nails Dev Team
 * @link
 */

namespace Nails\Database\Migration\Nails\ModuleFormBuilder;

use Nails\Common\Console\Migrate\Base;

class Migration2 extends Base
{
    /**
     * Execute the migration
     * @return Void
     */
    public function execute()
    {
        $this->query("ALTER TABLE `{{NAILS_DB_PREFIX}}formbuilder_form_field` CHANGE `label` `label` VARCHAR(255)  CHARACTER SET utf8  COLLATE utf8_general_ci  NOT NULL  DEFAULT '';");
    }
}
