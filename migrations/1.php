<?php

/**
 * Migration:   1
 * Started:     22/04/2016
 * Finalised:   22/04/2016
 *
 * @package     Nails
 * @subpackage  module-form-builder
 * @category    Database Migration
 * @author      Nails Dev Team
 * @link
 */

namespace Nails\Database\Migration\Nails\ModuleFormBuilder;

use Nails\Common\Console\Migrate\Base;

class Migration1 extends Base
{
    /**
     * Execute the migration
     * @return Void
     */
    public function execute()
    {
        $this->query("ALTER TABLE `{{NAILS_DB_PREFIX}}formbuilder_form` ADD `has_captcha` TINYINT(1)  UNSIGNED  NOT NULL  DEFAULT '0'  AFTER `id`;");
    }
}
