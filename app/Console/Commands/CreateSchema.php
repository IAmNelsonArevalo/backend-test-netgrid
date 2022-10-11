<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreateSchema extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:schema {name?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new mysql database';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $schemaName = $this->argument("name") ?: config("database.connections.mysql.database");
        $charset = config("database.connections.mysql.charset", "utf8mb4");
        $collation = config("database.connections.mysql.collation", "utf8mb4_unicode_ci");
        config(["database.connections.mysql.database" => null]);
        $query = "CREATE SCHEMA IF NOT EXISTS $schemaName CHARACTER SET $charset COLLATE $collation";
        DB::statement($query);
        config(["database.connections.mysql.database" => $schemaName]);
    }
}
