<?php

use Illuminate\Database\Seeder;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AssignDefaultPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = ['建物管理', '部屋管理', '座席管理', '座席登録', 'ユーザ管理'];
        $roles = [
            '管理者' => [''],
            '部局担当者' => ['建物管理', '部屋管理', '座席管理'],
            'ユーザ管理者' => ['ユーザ管理'],
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        foreach ($roles as $role_key => $role_val) {
            $role = Role::create(['name' => $role_key]);
            $role->syncPermissions($role_val);
        }
        // 最初に管理者として割り当てたい人
        $admin_user_ocuid = explode(',', config('oculocal.default_admin'));

        foreach ($admin_user_ocuid as $ocuid) {
            $user = User::where('ocuid', $ocuid)->first();
            if ($user) {
                $user->assignRole('管理者');
            }
        }


    }
}
