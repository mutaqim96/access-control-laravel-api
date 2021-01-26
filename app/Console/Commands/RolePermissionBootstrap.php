<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RolePermissionBootstrap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laravel_api:bootstrap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create roles and permissions';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $roles = ["Super Admin", "User Manager", "Role Manager"];

        $permissions = [
            "View All Users",
            "Edit All Users",
            "Assign Role",
            "Unassign Role",
            "View All Permissions",
            "View All Roles"];

        $this->line('------------- Setting Up Roles hai:');
        
        foreach($roles as $role)
        {
            $role = Role::updateOrCreate(['name'=> $role, 'guard_nmae'=> 'api']);

            $this->info("Created".$role->name . "Role");

        }//tutup foreach 1


        $this->line('---------- Setting Up Permissions:');

        $superAdminRole = Role::where('name', "Super Admin")->first();


        foreach ($permissions as $perm_name){
            
            $permission = Permission::updateOrCreate(['name'=> $perm_name, 'guard_name' => 'api']);

            $superAdminRole -> givePermissionTo($permission);

            $this->info("Created". $permission->name . "Permission");
        
        }//tutup foreach 2

        $this->info("All permissions are granted to Super Admin");
        $this->line("-------------- Application Bootstraping dah Siap : \n");

    }
}
