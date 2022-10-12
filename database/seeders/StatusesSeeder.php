<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $status = new Status();
        $status->name = "Active";
        $status->model = "All";
        $status->translation_status = "Activo";
        $status->save();

        $status = new Status();
        $status->name = "Inactive";
        $status->model = "All";
        $status->translation_status = "Inactivo";
        $status->save();
    }
}
