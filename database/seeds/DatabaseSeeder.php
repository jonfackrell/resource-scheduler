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
        $statuses = ['Pending Approval', 'Pending Print', 'Printing', 'Printing Complete'];
        $systemPermissions = [
            'view-departments' => 'View Departments', 'create-departments' => 'Create Departments', 'edit-departments' => 'Edit Departments', 'delete-departments' => 'Delete Departments',
            'view-filaments' => 'View Filaments', 'create-filaments' => 'Create Filaments','edit-filaments' => 'Edit Filaments', 'delete-filaments' => 'Delete Filaments',
            'view-colors' => 'View Colors', 'create-colors' => 'Create Colors', 'edit-colors' => 'Edit Colors', 'delete-colors' => 'Delete Colors',
            'view-patrons' => 'View Patrons', 'create-patrons' => 'Create Patrons', 'edit-patrons' => 'Edit Patrons', 'delete-patrons' => 'Delete Patrons',
            'view-statuses' => 'View Statuses', 'create-statuses' => 'Create Statuses', 'edit-statuses' => 'Edit Statuses', 'delete-statuses' => 'Delete Statuses',
            'view-print-jobs' => 'View Print Jobs', 'create-print-jobs' => 'Create Print Jobs', 'edit-print-jobs' => 'Edit Print Jobs', 'delete-print-jobs' => 'Delete Print Jobs',
            'accept-payments' => 'Accept Payments'
        ];


        $departments = factory(App\Models\Department::class, 5)->create();
        $printers = factory(App\Models\Printer::class, 3)->create();
        $users = factory(App\Models\User::class, 10)->create();
        $filaments = factory(App\Models\Filament::class, 20)->create();
        $colors = factory(App\Models\Color::class, 10)->create();
        $patrons = factory(App\Models\Patron::class, 100)->create();
        $printJobs = factory(App\Models\PrintJob::class, 60)->create();

        foreach ($statuses as $status){
            App\Models\Status::create([
                'name' => $status,
                'accept_payment' => rand(0, 1)
            ]);
        }

        foreach ($systemPermissions as $name => $label){
            App\Models\SystemPermission::create([
                'name' => $name,
                'label' => $label
            ]);
        }

        foreach ($filaments as $filament){
            foreach ($colors as $color){
                $filament->colors()->attach($color->id, ['quantity' => rand(0, 10)]);
            }
        }
    }
}
