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
        $colors = factory(App\Models\Color::class, 10)->create();
        $patrons = factory(App\Models\Patron::class, 100)->create();
        $printJobs = factory(App\Models\PrintJob::class, 60)->create();

        foreach ($filaments as $filament){
            foreach ($colors as $color){
                $filament->colors()->attach($color->id, ['quantity' => rand(0, 10)]);
            }
        }
    }
}
