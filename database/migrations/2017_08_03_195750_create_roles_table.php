<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('label')->nullable();
            $table->timestamps();
        });

        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('label')->nullable();
            $table->timestamps();
        });

        Schema::create('permission_role', function (Blueprint $table) {
            $table->integer('permission_id')->unsigned();
            $table->integer('role_id')->unsigned();

            $table->foreign('permission_id')
                ->references('id')
                ->on('permissions')
                ->onDelete('cascade');

            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->onDelete('cascade');

            $table->primary(['permission_id', 'role_id']);
        });

        Schema::create('role_user', function (Blueprint $table) {
            $table->integer('role_id')->unsigned();
            $table->integer('user_id')->unsigned();

            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->primary(['role_id', 'user_id']);
        });

        $systemRoles = ['administrator' => 'Administrator', 'supervisor' => 'Supervisor', 'employee' => 'Employee', 'payment-processor' => 'Payment Processor'];
        $systemPermissions = [
            'view-colors' => 'View Colors', 'create-colors' => 'Create Colors', 'edit-colors' => 'Edit Colors', 'delete-colors' => 'Delete Colors',
            'view-departments' => 'View Departments', 'create-departments' => 'Create Departments', 'edit-departments' => 'Edit Departments', 'delete-departments' => 'Delete Departments',
            'view-filaments' => 'View Filaments', 'create-filaments' => 'Create Filaments','edit-filaments' => 'Edit Filaments', 'delete-filaments' => 'Delete Filaments',
            'view-notifications' => 'View Notifications', 'create-notifications' => 'Create Notifications','edit-notifications' => 'Edit Notifications', 'delete-notifications' => 'Delete Notifications',
            'view-patrons' => 'View Patrons', 'create-patrons' => 'Create Patrons', 'edit-patrons' => 'Edit Patrons', 'delete-patrons' => 'Delete Patrons',
            'view-print-jobs' => 'View Print Jobs', 'create-print-jobs' => 'Create Print Jobs', 'edit-print-jobs' => 'Edit Print Jobs', 'delete-print-jobs' => 'Delete Print Jobs',
            'view-printers' => 'View Printers', 'create-printers' => 'Create Printers','edit-printers' => 'Edit Printers', 'delete-printers' => 'Delete Printers',
            'view-statuses' => 'View Statuses', 'create-statuses' => 'Create Statuses', 'edit-statuses' => 'Edit Statuses', 'delete-statuses' => 'Delete Statuses',
            'view-users' => 'View Users', 'create-users' => 'Create Users', 'edit-users' => 'Edit Users', 'delete-users' => 'Delete Users',
            'accept-payments' => 'Accept Payments',
            'update-pricing' => 'Update Pricing'
        ];

        foreach($systemRoles as $key => $systemRole){
            $role = \App\Models\Role::create([
                'name' => $key,
                'label' => $systemRole
            ]);
        }

        foreach($systemPermissions as $key => $systemPermission){
            $permission = \App\Models\Permission::create([
                'name' => $key,
                'label' => $systemPermission
            ]);
        }

        $administrator = \App\Models\Role::whereName('administrator')->first();
        $administrator->permissions()->sync(\App\Models\Permission::all());

        $supervisor = \App\Models\Role::whereName('supervisor')->first();
        $supervisor->permissions()->sync(
            \App\Models\Permission::where('name', 'LIKE', '%colors%')
                ->orWhere('name', 'LIKE', '%filaments%')
                ->orWhere('name', 'LIKE', '%notifications%')
                ->orWhere('name', 'LIKE', '%patrons%')
                ->orWhere('name', 'LIKE', '%print-jobs%')
                ->orWhere('name', 'LIKE', '%printers%')
                ->orWhere('name', 'LIKE', '%statuses%')
                ->orWhere('name', 'LIKE', '%users%')
                ->orWhere('name', 'LIKE', '%accept-payments%')
                ->orWhere('name', '=', 'edit-departments')
                ->orWhere('name', '=', 'update-pricing')
                ->get()
        );

        $employee = \App\Models\Role::whereName('employee')->first();
        $employee->permissions()->sync(
            \App\Models\Permission::where('name', 'LIKE', '%view%')
                ->orWhere('name', 'LIKE', '%accept-payments%')
                ->orWhere('name', '=', 'edit-colors')
                ->orWhere('name', '=', 'edit-patrons')
                ->orWhere('name', '=', 'edit-print-jobs')
                ->get()
        );

        $paymentProcessor = \App\Models\Role::whereName('payment-processor')->first();
        $paymentProcessor->permissions()->sync(
            \App\Models\Permission::where('name', 'LIKE', '%accept-payments%')
                ->orWhere('name', '=', 'view-patrons')
                ->orWhere('name', '=', 'view-print-jobs')
                ->orWhere('name', '=', 'edit-print-jobs')
                ->get()
        );

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_user');
        Schema::dropIfExists('permission_role');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('roles');
    }
}
