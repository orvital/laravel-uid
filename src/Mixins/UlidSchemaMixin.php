<?php

namespace Orvital\Uid\Mixins;
use Illuminate\Database\Schema\ForeignIdColumnDefinition;

/**
 * @mixin \Illuminate\Database\Schema\Blueprint
 */
class UlidSchemaMixin
{
    /**
     * Create a new Ulid column on the table.
     *
     * @return \Illuminate\Database\Schema\ColumnDefinition
     */
    public function ulid(): \Closure
    {
        return function (string $column = 'id') {
            return $this->char($column, 26);
            // return $this->addColumn('ulid', $column);
            // return $this->addColumn('ulid', $column);
        };
    }

    /**
     * Create a new Ulid column on the table with a foreign key constraint.
     *
     * @return \Illuminate\Database\Schema\ColumnDefinition
     */
    public function foreignUlid(): \Closure
    {
        // TODO refactor to match foreignId() and foreignUuid()
        // return function (string $column, string $table) {
        //     $definition = $this->ulid($column);

        //     $this->foreign($column)->references('id')->on($table);

        //     return $definition;
        // };

        return function (string $column) {
            return $this->addColumnDefinition(new ForeignIdColumnDefinition($this, [
                'type' => 'char',
                'name' => $column,
                'length' => 26,
            ]));
        };
    }

    /**
     * Add the proper columns for a polymorphic table using Ulids.
     *
     * @return void
     */
    public function ulidMorphs(): \Closure
    {
        return function (string $name, ?string $indexName = null) {
            $this->ulid("{$name}_id");

            $this->string("{$name}_type");

            // as a rule of thumb, the column with the fewest possible matches (the highest number of distinct values)
            // to the search criteria should come first in the index to narrow the result set down as much as possible.
            $this->index(["{$name}_id", "{$name}_type"], $indexName);
        };
    }
}
