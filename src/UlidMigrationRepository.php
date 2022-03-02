<?php

namespace Orvital\Uid;

use Illuminate\Database\Migrations\DatabaseMigrationRepository;
use Illuminate\Support\Facades\Date;
use Orvital\Uid\Ulid;

class UlidMigrationRepository extends DatabaseMigrationRepository
{
    public function log($file, $batch)
    {
        $this->table()->insert([
            'id' => Ulid::generate(),
            'migration' => $file,
            'batch' => $batch,
            'created_at' => Date::now(),
        ]);
    }

    public function createRepository()
    {
        $schema = $this->getConnection()->getSchemaBuilder();

        $schema->create($this->table, function ($table) {
            $table->ulid('id')->primary();
            $table->integer('batch');
            $table->string('migration');
            $table->dateTime('created_at');
        });
    }
}
