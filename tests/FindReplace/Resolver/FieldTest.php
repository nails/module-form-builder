<?php

namespace Tests\FindReplace\Resolver;

use Nails\FindReplace\Factory\Action;
use Nails\FindReplace\Factory\Hit;
use Nails\FindReplace\Factory\Matched;
use Nails\FindReplace\Interfaces\Resolver;
use Nails\FormBuilder\FindReplace\Resolver\Field;
use PHPUnit\Framework\TestCase;

class FieldTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        if (!defined('NAILS_DB_PREFIX')) {
            define('NAILS_DB_PREFIX', 'nails_');
        }
    }

    public function testTables(): void
    {
        self::assertSame(
            [NAILS_DB_PREFIX . 'formbuilder_form_field', NAILS_DB_PREFIX . 'formbuilder_form_field_option'],
            (new Field())->tables()
        );
    }

    public function testFieldsAreDescribedByTheirOwner(): void
    {
        $table = NAILS_DB_PREFIX . 'formbuilder_form_field';
        $hits = $this->resolver()->resolve($table, [
            $this->match($table, '10', 'label'),
            $this->match($table, '10', 'placeholder'),
            $this->match($table, '11', 'label'),
            $this->match($table, '12', 'label'),
            $this->match($table, '99', 'label'),
        ]);

        self::assertCount(3, $hits);

        self::assertSame('Form Field', $hits['10']->getEntityLabel());
        self::assertSame('10', $hits['10']->getEntityId());
        self::assertSame('Survey: Customer feedback › Email address', $hits['10']->getTitle());
        self::assertSame('Edit', $hits['10']->getActions()[0]->getLabel());
        self::assertSame('https://example.com/admin/survey/survey/edit/4', $hits['10']->getActions()[0]->getUrl());

        //  No resolver claims the owner's table.
        self::assertSame(NAILS_DB_PREFIX . 'custom_form #7 › Name', $hits['11']->getTitle());
        self::assertSame([], $hits['11']->getActions());

        //  Nothing references the form.
        self::assertSame('Form #3 › Orphaned', $hits['12']->getTitle());
        self::assertSame([], $hits['12']->getActions());
    }

    public function testOptionsAreDescribedThroughTheirField(): void
    {
        $table = NAILS_DB_PREFIX . 'formbuilder_form_field_option';
        $hits = $this->resolver()->resolve($table, [
            $this->match($table, '100', 'label'),
            $this->match($table, '101', 'label'),
        ]);

        self::assertSame(['100'], array_map('strval', array_keys($hits)));
        self::assertSame('Form Field Option', $hits['100']->getEntityLabel());
        self::assertSame('100', $hits['100']->getEntityId());
        self::assertSame('Survey: Customer feedback › Email address › Work', $hits['100']->getTitle());
        self::assertSame('https://example.com/admin/survey/survey/edit/4', $hits['100']->getActions()[0]->getUrl());
    }

    public function testNoMatchesResolvesNothing(): void
    {
        self::assertSame([], $this->resolver()->resolve(NAILS_DB_PREFIX . 'formbuilder_form_field', []));
    }

    private function match(string $table, string $id, string $column): Matched
    {
        return new Matched($table, $column, 'plaintext', 'example', $id, 'example');
    }

    private function resolver(): Field
    {
        $surveys = new class implements Resolver {
            public function tables(): array
            {
                return [NAILS_DB_PREFIX . 'survey_survey'];
            }

            public function resolve(string $table, array $matches): array
            {
                $hits = [];

                foreach ($matches as $match) {
                    $hits[$match->getId()] = new Hit(
                        $table,
                        $match->getId(),
                        entityLabel: 'Survey',
                        entityId: $match->getId(),
                        title: 'Customer feedback',
                        actions: [
                            new Action('Edit', 'https://example.com/admin/survey/survey/edit/' . $match->getId()),
                        ],
                    );
                }

                return $hits;
            }
        };

        return new class ($surveys) extends Field {
            public function __construct(private readonly Resolver $surveys)
            {
            }

            protected function rows(string $table, string $columns, array $ids): array
            {
                $rows = [
                    NAILS_DB_PREFIX . 'formbuilder_form_field' => [
                        (object) ['id' => 10, 'form_id' => 1, 'label' => 'Email address'],
                        (object) ['id' => 11, 'form_id' => 2, 'label' => 'Name'],
                        (object) ['id' => 12, 'form_id' => 3, 'label' => 'Orphaned'],
                    ],
                    NAILS_DB_PREFIX . 'formbuilder_form_field_option' => [
                        (object) ['id' => 100, 'form_field_id' => 10, 'label' => 'Work'],
                        (object) ['id' => 101, 'form_field_id' => 98, 'label' => 'Missing field'],
                    ],
                ];

                return array_values(array_filter(
                    $rows[$table] ?? [],
                    fn(\stdClass $row): bool => in_array((string) $row->id, $ids, true)
                ));
            }

            protected function references(): array
            {
                return [
                    ['table' => NAILS_DB_PREFIX . 'custom_form', 'column' => 'form_id', 'primary_key' => 'id'],
                    ['table' => NAILS_DB_PREFIX . 'survey_survey', 'column' => 'form_id', 'primary_key' => 'id'],
                ];
            }

            protected function ownerIds(string $table, string $column, string $primaryKey, array $formIds): array
            {
                $owners = [
                    NAILS_DB_PREFIX . 'custom_form' => ['2' => '7'],
                    NAILS_DB_PREFIX . 'survey_survey' => ['1' => '4'],
                ];

                return array_intersect_key($owners[$table], array_flip($formIds));
            }

            protected function ownerResolver(string $table): ?Resolver
            {
                return in_array($table, $this->surveys->tables(), true) ? $this->surveys : null;
            }
        };
    }
}
