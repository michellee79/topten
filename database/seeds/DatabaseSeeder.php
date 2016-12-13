<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

         $this->call(IndustryTableSeeder::class);
         $this->call(EmailsTableSeeder::class);

        Model::reguard();
    }
}
