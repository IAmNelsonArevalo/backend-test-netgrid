<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $user = new User();
        $user->name = "Nelson Eduardo Arevalo Cubides";
        $user->email = "nelson.arevalo2119@gmail.com";
        $user->password = Hash::make("Password");
        $user->address = "Carrera 67 # 57V Sur - 09";
        $user->complement = "Torre 6 - Apartamento 1048";
        $user->city = "Bogota D.C.";
        $user->birthday = Carbon::parse("1996-05-06")->format("Y-m-d H:i:s");
        $user->status_id = 1;
        $user->save();
    }
}
