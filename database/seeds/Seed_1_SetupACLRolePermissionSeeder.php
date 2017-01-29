<?php

use Illuminate\Database\Seeder;
use Kodeine\Acl\Models\Eloquent\User;
use Kodeine\Acl\Models\Eloquent\Role;
use Kodeine\Acl\Models\Eloquent\Permission;

class Seed_1_SetupACLRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $user = new User();
      $user->username = 'administrator';
      $user->first_name = 'Administrator';
      $user->last_name = 'System';
      $user->email = 'default@system.dev';
      $user->password = bcrypt('defaultpwd');
      $user->save();

      $role = new Role();
      $roleAdministrator = $role->create([
        'name' => 'Administrator',
        'slug' => 'administrator',
        'description' => 'manage super admin privileges'
      ]);

      $role = new Role();
      $roleAdmin = $role->create([
        'name' => 'Admin',
        'slug' => 'admin',
        'description' => 'manage admin privileges'
      ]);
      //assign user to role
      $user->assignRole($roleAdministrator);

      $permission = new Permission();
      $permUser = $permission->create([
          'name'        => 'user',
          'slug'        => [          // pass an array of permissions.
              'create'     => true,
              'view'       => true,
              'update'     => true,
              'delete'     => true,
              'view.phone' => true
          ],
          'description' => 'manage user permissions'
      ]);

      $permission = new Permission();
      $permRole = $permission->create([
          'name'        => 'role',
          'slug'        => [          // pass an array of permissions.
              'create'     => true,
              'view'       => true,
              'update'     => true,
              'delete'     => true,
              'view.phone' => true
          ],
          'description' => 'manage role permissions'
      ]);

      $permission = new Permission();
      $perm = $permission->create([
          'name'        => 'permissions',
          'slug'        => [          // pass an array of permissions.
              'create'     => true,
              'view'       => true,
              'update'     => true,
              'delete'     => true,
              'view.phone' => true
          ],
          'description' => 'manage permissions'
      ]);

      // assign multiple permissions to role with name separated by comma or pipe.
      $roleAdministrator->assignPermission('user, role, permissions');
    }
}
