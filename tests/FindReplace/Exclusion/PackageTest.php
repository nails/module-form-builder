<?php

namespace Tests\FindReplace\Exclusion;

use Nails\FormBuilder\FindReplace\Exclusion\Package;
use PHPUnit\Framework\TestCase;

class PackageTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        if (!defined('NAILS_DB_PREFIX')) {
            define('NAILS_DB_PREFIX', 'nails_');
        }
    }

    public function testHidden(): void
    {
        self::assertSame(
            [],
            (new Package())->hidden()
        );
    }

    public function testReadOnly(): void
    {
        self::assertSame(
            [
                NAILS_DB_PREFIX . 'formbuilder_form_field.type',
                NAILS_DB_PREFIX . 'formbuilder_form_field.default_value',
                NAILS_DB_PREFIX . 'formbuilder_form_field.custom_attributes',
            ],
            (new Package())->readOnly()
        );
    }
}
