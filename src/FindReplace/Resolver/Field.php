<?php

namespace Nails\FormBuilder\FindReplace\Resolver;

use Nails\Common\Service\Database;
use Nails\Factory;
use Nails\FindReplace\Constants;
use Nails\FindReplace\Factory\Hit;
use Nails\FindReplace\Factory\Matched;
use Nails\FindReplace\Factory\Term\Variant\Plaintext;
use Nails\FindReplace\Interfaces\Resolver;
use Nails\FindReplace\Service\Registry;

/**
 * Forms have no name or admin screen of their own; they are edited on whatever
 * owns them (a survey, a custom form, an app record). The owner is found through
 * foreign keys to the form table and described by the resolver for its table.
 */
class Field implements Resolver
{
    /**
     * The engine passes every match in a table at once; a long IN () list
     * overflows CodeIgniter's where_in parser, so IDs are queried in chunks.
     */
    const IDS_PER_QUERY = 500;

    public function tables(): array
    {
        return [
            NAILS_DB_PREFIX . 'formbuilder_form_field',
            NAILS_DB_PREFIX . 'formbuilder_form_field_option',
        ];
    }

    public function resolve(string $table, array $matches): array
    {
        $ids = array_values(array_unique(array_map(fn(Matched $match): string => $match->getId(), $matches)));

        if ($ids === []) {
            return [];
        }

        $isOption = $table === NAILS_DB_PREFIX . 'formbuilder_form_field_option';
        $options = $isOption
            ? $this->rows($table, 'id, form_field_id, label', $ids)
            : [];

        $fieldIds = $isOption
            ? array_values(array_unique(array_map(fn(\stdClass $option): string => (string) $option->form_field_id, $options)))
            : $ids;

        $fields = [];

        if ($fieldIds !== []) {
            foreach ($this->rows(NAILS_DB_PREFIX . 'formbuilder_form_field', 'id, form_id, label', $fieldIds) as $field) {
                $fields[(string) $field->id] = $field;
            }
        }

        $owners = $this->owners(array_values(array_unique(array_map(
            fn(\stdClass $field): string => (string) $field->form_id,
            $fields
        ))));

        $hits = [];

        if (!$isOption) {
            foreach ($fields as $id => $field) {
                $hits[(string) $id] = $this->hit($table, (string) $id, 'Form Field', $field, $owners, []);
            }

            return $hits;
        }

        foreach ($options as $option) {
            $field = $fields[(string) $option->form_field_id] ?? null;

            if ($field === null) {
                continue;
            }

            $id = (string) $option->id;
            $hits[$id] = $this->hit($table, $id, 'Form Field Option', $field, $owners, [(string) $option->label]);
        }

        return $hits;
    }

    /**
     * @param array<string, Hit> $owners
     * @param list<string> $trail
     */
    private function hit(string $table, string $id, string $entityLabel, \stdClass $field, array $owners, array $trail): Hit
    {
        $formId = (string) $field->form_id;
        $owner = $owners[$formId] ?? null;
        $title = array_filter([
            $owner !== null ? $this->describe($owner) : 'Form #' . $formId,
            (string) $field->label,
            ...$trail,
        ]);

        return new Hit(
            $table,
            $id,
            entityLabel: $entityLabel,
            entityId: $id,
            title: implode(' › ', $title),
            actions: $owner?->getActions() ?? [],
        );
    }

    private function describe(Hit $owner): string
    {
        $label = (string) $owner->getEntityLabel();
        $title = (string) $owner->getTitle();

        if ($label === '') {
            return $title;
        }

        return $title !== ''
            ? $label . ': ' . $title
            : $label . ' #' . ($owner->getEntityId() ?? $owner->getId());
    }

    /**
     * The first owner of each form, keyed by form ID.
     *
     * @param list<string> $formIds
     *
     * @return array<string, Hit>
     */
    private function owners(array $formIds): array
    {
        $owners = [];

        if ($formIds === []) {
            return $owners;
        }

        foreach ($this->references() as $reference) {
            $pending = array_values(array_filter($formIds, fn(string $formId): bool => !isset($owners[$formId])));

            if ($pending === []) {
                break;
            }

            $ownerIds = $this->ownerIds($reference['table'], $reference['column'], $reference['primary_key'], $pending);

            if ($ownerIds === []) {
                continue;
            }

            $resolver = $this->ownerResolver($reference['table']);
            $resolved = [];

            if ($resolver !== null) {
                $resolved = $resolver->resolve(
                    $reference['table'],
                    array_map(
                        fn(string $ownerId): Matched => new Matched(
                            $reference['table'],
                            $reference['column'],
                            Plaintext::ENCODING,
                            '',
                            $ownerId,
                            '',
                        ),
                        array_values(array_unique($ownerIds))
                    )
                );
            }

            foreach ($ownerIds as $formId => $ownerId) {
                $owners[(string) $formId] = $resolved[$ownerId] ?? new Hit(
                    $reference['table'],
                    $ownerId,
                    title: $reference['table'] . ' #' . $ownerId,
                );
            }
        }

        return $owners;
    }

    /**
     * Columns that hold a form ID, on tables with a single-column primary key.
     *
     * @return list<array{table: string, column: string, primary_key: string}>
     */
    protected function references(): array
    {
        /** @var Database $database */
        $database = Factory::service('Database');
        $rows = $database
            ->query(
                'SELECT k.TABLE_NAME AS table_name, k.COLUMN_NAME AS column_name, MAX(p.COLUMN_NAME) AS primary_key
                FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE k
                INNER JOIN INFORMATION_SCHEMA.KEY_COLUMN_USAGE p
                    ON p.TABLE_SCHEMA = k.TABLE_SCHEMA
                    AND p.TABLE_NAME = k.TABLE_NAME
                    AND p.CONSTRAINT_NAME = \'PRIMARY\'
                WHERE k.TABLE_SCHEMA = DATABASE()
                    AND k.REFERENCED_TABLE_NAME = ?
                    AND k.REFERENCED_COLUMN_NAME = \'id\'
                    AND k.TABLE_NAME <> ?
                GROUP BY k.TABLE_NAME, k.COLUMN_NAME
                HAVING COUNT(DISTINCT p.COLUMN_NAME) = 1
                ORDER BY k.TABLE_NAME, k.COLUMN_NAME',
                [
                    NAILS_DB_PREFIX . 'formbuilder_form',
                    NAILS_DB_PREFIX . 'formbuilder_form_field',
                ]
            )
            ->result();

        return array_map(
            fn(\stdClass $row): array => [
                'table' => (string) $row->table_name,
                'column' => (string) $row->column_name,
                'primary_key' => (string) $row->primary_key,
            ],
            $rows
        );
    }

    /**
     * The first row in $table that uses each form, keyed by form ID.
     *
     * @param list<string> $formIds
     *
     * @return array<string, string>
     */
    protected function ownerIds(string $table, string $column, string $primaryKey, array $formIds): array
    {
        /** @var Database $database */
        $database = Factory::service('Database');
        $ownerIds = [];

        foreach (array_chunk($formIds, static::IDS_PER_QUERY) as $chunk) {
            $database->select($primaryKey . ', ' . $column);
            $database->where_in($column, $chunk);
            $database->order_by($primaryKey);

            foreach ($database->get($table)->result() as $row) {
                $formId = (string) $row->{$column};
                $ownerIds[$formId] ??= (string) $row->{$primaryKey};
            }
        }

        return $ownerIds;
    }

    protected function ownerResolver(string $table): ?Resolver
    {
        /** @var Registry $registry */
        $registry = Factory::service('Registry', Constants::MODULE_SLUG);

        foreach ($registry->resolvers() as $resolver) {
            if (!$resolver instanceof self && in_array($table, $resolver->tables(), true)) {
                return $resolver;
            }
        }

        return null;
    }

    /**
     * @param list<string> $ids
     *
     * @return list<\stdClass>
     */
    protected function rows(string $table, string $columns, array $ids): array
    {
        /** @var Database $database */
        $database = Factory::service('Database');
        $rows = [];

        foreach (array_chunk($ids, static::IDS_PER_QUERY) as $chunk) {
            $database->select($columns);
            $database->where_in('id', $chunk);
            $rows = array_merge($rows, $database->get($table)->result());
        }

        return $rows;
    }
}
