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
        $statuses = ['Pending Approval', 'Pending Print', 'Printing', 'Printing Complete', 'Denied'];
        $systemPermissions = [
            'view-departments' => 'View Departments', 'create-departments' => 'Create Departments', 'edit-departments' => 'Edit Departments', 'delete-departments' => 'Delete Departments',
            'view-filaments' => 'View Filaments', 'create-filaments' => 'Create Filaments','edit-filaments' => 'Edit Filaments', 'delete-filaments' => 'Delete Filaments',
            'view-printers' => 'View Printers', 'create-printers' => 'Create Printers','edit-printers' => 'Edit Printers', 'delete-printers' => 'Delete Printers',
            'view-colors' => 'View Colors', 'create-colors' => 'Create Colors', 'edit-colors' => 'Edit Colors', 'delete-colors' => 'Delete Colors',
            'view-patrons' => 'View Patrons', 'create-patrons' => 'Create Patrons', 'edit-patrons' => 'Edit Patrons', 'delete-patrons' => 'Delete Patrons',
            'view-statuses' => 'View Statuses', 'create-statuses' => 'Create Statuses', 'edit-statuses' => 'Edit Statuses', 'delete-statuses' => 'Delete Statuses',
            'view-print-jobs' => 'View Print Jobs', 'create-print-jobs' => 'Create Print Jobs', 'edit-print-jobs' => 'Edit Print Jobs', 'delete-print-jobs' => 'Delete Print Jobs',
            'accept-payments' => 'Accept Payments'
        ];


        //$departments = factory(App\Models\Department::class, 5)->create();
        //$printers = factory(App\Models\Printer::class, 3)->create();
        $users = factory(App\Models\User::class, 10)->create();
        //$filaments = factory(App\Models\Filament::class, 20)->create();
        //$colors = factory(App\Models\Color::class, 10)->create();
        $patrons = factory(App\Models\Patron::class, 100)->create();
        $printJobs = factory(App\Models\PrintJob::class, 100)->create();

        $settings                   = new \App\Models\Setting();
        $settings->name             = 'HEADER_HTML';
        $settings->value            = '';
        $settings->group            = 'PUBLIC';
        $settings->order            = 1;
        $settings->save();

        $settings                   = new \App\Models\Setting();
        $settings->name             = 'HEADER_CSS';
        $settings->value            = '';
        $settings->group            = 'PUBLIC';
        $settings->order            = 2;
        $settings->save();

        $settings                   = new \App\Models\Setting();
        $settings->name             = 'FOOTER_HTML';
        $settings->value            = '';
        $settings->group            = 'PUBLIC';
        $settings->order            = 3;
        $settings->save();

        $settings                   = new \App\Models\Setting();
        $settings->name             = 'FOOTER_JS';
        $settings->value            = '';
        $settings->group            = 'PUBLIC';
        $settings->order            = 5;
        $settings->save();
        // TODO: Add logo url
        $settings                   = new \App\Models\Setting();
        $settings->name             = 'LOGO';
        $settings->value            = '//library.byui.edu/images/byu-idaho-logo.png';
        $settings->group            = 'PUBLIC';
        $settings->order            = 5;
        $settings->save();


        App\Models\Department::create([
            'name' => 'McKay Library',
            'description' => 'MCK 140',
            'initial_status' => 1,
            'terms' => 'By clicking \'Submit\' you agree to paying the total cost listed within 2 weeks of printing.'
        ]);

        App\Models\Department::create([
            'name' => 'ME Department',
            'description' => 'Austin'
        ]);

        App\Models\Department::create([
            'name' => 'Art Department',
            'description' => 'Spori'
        ]);

        App\Models\Printer::create([
            'name' => 'LulzBot Taz 6',
            'description' => 'The LulzBot TAZ 6 boasts multiple tool head upgrade options such as the Flexystruder for reliable printing of flexible filaments and the Dual Extruder and FlexyDually tool heads, for two-color or multi-material 3D printing. The LulzBot TAZ 6 utilizes an open filament format. This means you have the freedom to choose from dozens of leading and new materials, with over 300 quickprint profiles in Cura LulzBot Edition out-of-the-box. You can learn how your robot works, make modifications, and share with the community.',
            'department' => 1,
            'image' => 'https://www.lulzbot.com/sites/default/files/TAZ_6_Angle_Main_Product_Page.png',
            'flat_fee' => 0,
            'per_hour' => 0,
            'overtime_fee' => 1,
            'overtime_start' => 12
        ]);

        App\Models\Printer::create([
            'name' => 'Altair',
            'description' => 'With the click of a button an Altair printer can calibrate its print bed automatically, making it easy to get accurate prints and optimal first layer adhesion.',
            'department' => 2,
            'image' => 'https://www.printspace3d.com/wp-content/uploads/2015/01/Altair-9684_MD_CMYK_NoSpoolHolder_WEB2-201x300.jpg',
            'flat_fee' => 0,
            'per_hour' => 2,
            'overtime_fee' => 0,
            'overtime_start' => 0
        ]);

        App\Models\Printer::create([
            'name' => 'Ultimaker 3',
            'description' => ' Ultimaker 3’s range of materials are formulated to achieve superior results. Optimized Cura profiles offer the best print settings per material and recognize which print core and material you’re using.',
            'department' => 3,
            'image' => 'https://d3v5bfco3dani2.cloudfront.net/src/media/image/products/um3/buy/img-um3.png',
            'flat_fee' => 5,
            'per_hour' => 0,
            'overtime_fee' => 0,
            'overtime_start' => 0
        ]);


        App\Models\Filament::create([
            'name' => 'PolyLite PLA',
            'description' => 'This premium filament 3D prints reliably and has minimal warping and shrinking compared to other materials, perfect for applications featuring flat surfaces and hard angles, or requiring tight tolerances for fit.',
            'department' => 1
        ]);

        App\Models\Filament::create([
            'name' => 'nGen',
            'description' => 'nGen is engineered for prototyping and production. This co-polyester filament by colorFabb brings together strength and precision optimized for desktop 3D printing. nGen handles complex models well, including bridging gaps, holes, and overhangs. It also exhibits minimal warping and responds well to post-processing techniques like sanding.',
            'department' => 1
        ]);

        App\Models\Filament::create([
            'name' => 'NinjaFlex',
            'description' => 'NinjaFlex performs with an exciting combination of elongation, elasticity, and strength. NinjaFlex comes in many colors that have a beautiful, strong sheen after being 3D printed. NinjaFlex is a premium and high quality filament material capable of opening the door to a wide range of new applications for your LulzBot desktop 3D printer',
            'department' => 1
        ]);


        App\Models\Color::create([
            'name' => 'Black',
            'hex_code' => '000000'
        ]);
        App\Models\Color::create([
            'name' => 'LulzBot Green',
            'hex_code' => 'c2eb39'
        ]);
        App\Models\Color::create([
            'name' => 'Natural',
            'hex_code' => 'e6d092'
        ]);
        App\Models\Color::create([
            'name' => 'Teal',
            'hex_code' => '6ad0e7'
        ]);
        App\Models\Color::create([
            'name' => 'Translucent Blue',
            'hex_code' => '4097f5'
        ]);
        App\Models\Color::create([
            'name' => 'Translucent Orange',
            'hex_code' => 'fd9c16'
        ]);
        App\Models\Color::create([
            'name' => 'Translucent Red',
            'hex_code' => 'fd663d'
        ]);
        App\Models\Color::create([
            'name' => 'Translucent Yellow',
            'hex_code' => 'fcca1d'
        ]);
        App\Models\Color::create([
            'name' => 'True Blue',
            'hex_code' => '234dbc'
        ]);
        App\Models\Color::create([
            'name' => 'True Green',
            'hex_code' => '4ea875'
        ]);
        App\Models\Color::create([
            'name' => 'True Grey',
            'hex_code' => '808185'
        ]);
        App\Models\Color::create([
            'name' => 'True Orange',
            'hex_code' => 'fd7d1f'
        ]);
        App\Models\Color::create([
            'name' => 'True Purple',
            'hex_code' => '9870e1'
        ]);
        App\Models\Color::create([
            'name' => 'True Red',
            'hex_code' => 'f95635'
        ]);
        App\Models\Color::create([
            'name' => 'True White',
            'hex_code' => 'eceade'
        ]);
        App\Models\Color::create([
            'name' => 'True Yellow',
            'hex_code' => 'ffdf20'
        ]);


        foreach ($statuses as $status){
            App\Models\Status::create([
                'name' => $status,
                'department' => \App\Models\User::first()->department,
                'accept_payment' => rand(0, 1),
                'dashboard_display' => 1
            ]);
        }

        foreach ($systemPermissions as $name => $label){
            App\Models\SystemPermission::create([
                'name' => $name,
                'label' => $label
            ]);
        }

        $filaments = \App\Models\Filament::all();
        $colors = \App\Models\Color::all();
        $departments = \App\Models\Department::all();
        foreach($departments as $department){
            foreach ($filaments as $filament){
                foreach ($colors as $color){
                    $filament->colors()->attach($color->id, [
                        'quantity' => rand(250, 3000),
                        'department' => $department->id
                    ]);
                }
            }
        }

        $printers = \App\Models\Printer::all();
        foreach ($printers as $printer){
            foreach ($filaments as $filament){
                $printer->filaments()->attach($filament->id, [
                    'cost_per_gram' => 2.5,
                    'add_cost_per_gram' => 5,
                    'multiplier' => 1
                ]);
            }
        }
    }
}
