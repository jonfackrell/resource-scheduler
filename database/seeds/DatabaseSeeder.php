<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments = factory(App\Models\Department::class, 5)->create();
        $users = factory(App\Models\User::class, 10)->create();
        $filaments = factory(App\Models\Filament::class, 20)->create();
    }
}
