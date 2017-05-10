<?php

use Illuminate\Database\Seeder;

class MigrationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         factory(App\HumanMigration::class,1000)->create();
    }
}
