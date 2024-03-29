<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class LaratrustSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->truncateLaratrustTables();

        $config = Config::get('laratrust_seeder.roles_structure');

        if ($config === null) {
            $this->command->error("The configuration has not been published. Did you run `php artisan vendor:publish --tag=\"laratrust-seeder\"`");
            $this->command->line('');
            return false;
        }

        $mapPermission = collect(config('laratrust_seeder.permissions_map'));

        foreach ($config as $key => $modules) {

            // Create a new role
            $role = \App\Models\Role::firstOrCreate([
                'name' => $key,
                'display_name' => ucwords(str_replace('_', ' ', $key)),
                'description' => ucwords(str_replace('_', ' ', $key))
            ]);
            $permissions = [];

            $this->command->info('Creating Role '. strtoupper($key));

            // Reading role permission modules
            foreach ($modules as $module => $value) {

                foreach (explode(',', $value) as $perm) {

                    $permissionValue = $mapPermission->get($perm);

                    $permissions[] = \App\Models\Permission::firstOrCreate([
                        'name' => $module . '-' . $permissionValue,
                        'display_name' => ucfirst($permissionValue) . ' ' . ucfirst($module),
                        'description' => ucfirst($permissionValue) . ' ' . ucfirst($module),
                    ])->id;

                    $this->command->info('Creating Permission to '.$permissionValue.' for '. $module);
                }
            }

            // Add all permissions to the role
            $role->permissions()->sync($permissions);

            if (Config::get('laratrust_seeder.create_users')) {
                $this->command->info("Creating '{$key}' user");
                // Create default user for each role
                $user = \App\Models\User::create([
                    'name' => ucwords(str_replace('_', ' ', $key)),
                    'email' => $key.'@app.com',
                    'password' => bcrypt('12345')
                ]);
                $user->addRole($role);
            }

        }
    }

    /**
     * Truncates all the laratrust tables and the users table
     *
     * @return  void
     */
    public function truncateLaratrustTables()
    {
        $this->command->info('Truncating User, Role and Permission tables');
        Schema::disableForeignKeyConstraints();

        DB::table('permission_role')->truncate();
        DB::table('permission_user')->truncate();
        DB::table('role_user')->truncate();

        if (Config::get('laratrust_seeder.truncate_tables')) {
            DB::table('roles')->truncate();
            DB::table('permissions')->truncate();

            if (Config::get('laratrust_seeder.create_users')) {
                $usersTable = (new \App\Models\User)->getTable();
                DB::table($usersTable)->truncate();
            }
        }

        Schema::enableForeignKeyConstraints();
    }













    // public function run()
    // {
    //     $this->command->info('Truncating User, Role and Permission tables');
    //     $this->truncateLaratrustTables();

    //     $config = config('laratrust_seeder.role_structure');
    //     $userPermission = config('laratrust_seeder.permission_structure');
    //     $mapPermission = collect(config('laratrust_seeder.permissions_map'));
    //     $i = 0;
    //     foreach ($config as $key => $modules) {

    //         // Create a new role
    //         $role = \App\Models\Role::create([
    //             'name' => $key,
    //             'display_name' => ucwords(str_replace('_', ' ', $key)),
    //             'description' => ucwords(str_replace('_', ' ', $key))
    //         ]);
    //         $permissions = [];

    //         $this->command->info('Creating Role ' . strtoupper($key));

    //         // Reading role permission modules
    //         foreach ($modules as $module => $value) {

    //             foreach (explode(',', $value) as $p => $perm) {

    //                 $permissionValue = $mapPermission->get($perm);

    //                 $permissions[] = \App\Models\Permission::firstOrCreate([
    //                     'name' => $permissionValue . '-' . $module,
    //                     'display_name' => ucfirst($permissionValue) . ' ' . ucfirst($module),
    //                     'description' => ucfirst($permissionValue) . ' ' . ucfirst($module),
    //                 ])->id;

    //                 $this->command->info('Creating Permission to ' . $permissionValue . ' for ' . $module);
    //             }
    //         }

    //         // Attach all permissions to the role
          
    //         if ($i == 0) {
    //             $role->permissions()->sync($permissions);

    //             $this->command->info("Creating '{$key}' user");

    //             // Create default user for each role
    //             $user = \App\Models\User::create([
    //                 'name' => ucwords(str_replace('_', ' ', $key)),
    //                 'email' => $key . '@eg.com',
    //                 'password' => bcrypt('12345'),
    //                 // 'type' => 1,
    //             ]);

    //             $user->attachRole($role);
    //         }
    //         $i++;
    //     }

    //     // Creating user with permissions
    //     if (!empty($userPermission)) {

    //         foreach ($userPermission as $key => $modules) {

    //             foreach ($modules as $module => $value) {

    //                 // Create default user for each permission set
    //                 $user = \App\Models\User::create([
    //                     'name' => ucwords(str_replace('_', ' ', $key)),
    //                     'email' => $key . '@app.com',
    //                     'password' => bcrypt('password'),
    //                     'remember_token' => Str::random(10),
    //                 ]);
    //                 $permissions = [];

    //                 foreach (explode(',', $value) as $p => $perm) {

    //                     $permissionValue = $mapPermission->get($perm);

    //                     $permissions[] = \App\Models\Permission::firstOrCreate([
    //                         'name' => $permissionValue . '-' . $module,
    //                         'display_name' => ucfirst($permissionValue) . ' ' . ucfirst($module),
    //                         'description' => ucfirst($permissionValue) . ' ' . ucfirst($module),
    //                     ])->id;

    //                     $this->command->info('Creating Permission to ' . $permissionValue . ' for ' . $module);
    //                 }
    //             }

    //             // Attach all permissions to the user
    //             $user->permissions()->sync($permissions);
    //         }
    //     }
    // }

    // /**
    //  * Truncates all the laratrust tables and the users table
    //  *
    //  * @return    void
    //  */
    // public function truncateLaratrustTables()
    // {
    //     Schema::disableForeignKeyConstraints();
    //     DB::table('permission_role')->truncate();
    //     DB::table('permission_user')->truncate();
    //     DB::table('role_user')->truncate();
    //     \App\Models\User::truncate();
    //     \App\Models\Role::truncate();
    //     \App\Models\Permission::truncate();
    //     Schema::enableForeignKeyConstraints();
    // }






}
