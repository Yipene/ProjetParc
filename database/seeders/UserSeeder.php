<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('users')->insert([

            ///////   ADMIN  /////////////////

            [
                'name' => 'Admin',
                'prenom' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('1111'),
                'statut' => 'actif',
                'role' => 'admin'
            ],

            ////// GESTIONNAIRE  //////////

            [
                'name' => 'Gestionnaire',
                'prenom' => 'gestionnaire',
                'email' => 'gestionnaire@gmail.com',
                'password' => Hash::make('1111'),
                'statut' => 'actif',
                'role' => 'gestionnaire'

            ],


            /////////////  TECHNICIEN    //////////////

            [
                'name' => 'maintenance',
                'prenom' => 'technicien',
                'email' => 'maintenance@gmail.com',
                'password' => Hash::make('1111'),
                'statut' => 'actif',
                'role' => 'technicien'
            ],



        ]);
    }
}
