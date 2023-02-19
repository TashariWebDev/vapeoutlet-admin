<?php

namespace App\Console\Commands;

use App\Models\Permission;
use App\Models\PermissionUser;
use App\Models\SalesChannel;
use App\Models\SystemSetting;
use App\Models\User;
use Artisan;
use Illuminate\Console\Command;

class ShopSetupCommand extends Command
{
    protected $signature = 'shop:setup';

    protected $description = 'Command description';

    public function handle()
    {
        $this->info('setting up app');

        $this->info('running migrations');

        Artisan::call('migrate');

        $this->info('migrations processed');

        $this->info('setting up default users');

        $email = $this->ask('What is your email?');
        $password = $this->ask('What is your password?');

        $encryptedPassword = bcrypt($password);

        $this->info('encrypting password');

        $superAdmin = User::updateOrCreate(
            [
                'name' => 'Super Admin',
                'email' => $email,
            ],
            [
                'name' => 'Super Admin',
                'email' => $email,
                'password' => $encryptedPassword,
                'is_super_admin' => true,
            ]
        );

        $admin = User::updateOrCreate(
            [
                'name' => 'Admin',
                'email' => 'admin@admin.com',
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt('password'),
            ]
        );

        $permissions = [
            'view orders',
            'edit orders',
            'create orders',
            'create purchase',
            'view warehouse',
            'view reports',
            'view users',
            'edit pricing',
            'view products',
            'view customers',
            'view inventory',
            'view expenses',
            'view settings',
            'view suppliers',
            'edit customers',
            'create credit',
            'view cost',
            'upgrade customers',
            'add transactions',
            'complete orders',
            'edit transactions',
            'edit products',
            'edit sales channels',
            'transfer stock',
            'manage stock takes',
        ];

        $this->info('creating permissions');

        Permission::truncate();

        foreach ($permissions as $permission) {
            Permission::updateOrCreate([
                'name' => $permission,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->info('assigning all permissions to default user');

        $permissions = Permission::all()->pluck('id');

        PermissionUser::truncate();

        $superAdmin->permissions()->sync($permissions);
        $admin->permissions()->sync($permissions);

        $this->info('creating default sales channel');

        SalesChannel::truncate();

        $defaultSalesChannel = SalesChannel::updateOrCreate(
            [
                'name' => 'warehouse',
            ],
            [
                'name' => 'warehouse',
                'is_locked_for_deletion' => true,
                'allows_shipping' => true,
            ]
        );

        $this->info('assigning default user to default sales channel');

        $superAdmin->sales_channels()->detach($defaultSalesChannel);
        $admin->sales_channels()->detach($defaultSalesChannel);
        $superAdmin
            ->sales_channels()
            ->attach($defaultSalesChannel, ['is_default' => true]);
        $admin
            ->sales_channels()
            ->attach($defaultSalesChannel, ['is_default' => true]);

        SystemSetting::updateOrCreate(
            ['company_name' => config('app.name')],
            ['company_name' => config('app.name')]
        );

        $folders = ['images', 'documents', 'uploads'];

        $this->info('setting up storage folders');

        foreach ($folders as $folder) {
            if (
                ! file_exists(
                    storage_path(
                        'app/public/'.
                            config('app.storage_folder').
                            "/$folder/"
                    )
                )
            ) {
                mkdir(
                    storage_path(
                        'app/public/'.
                            config('app.storage_folder').
                            "/$folder/"
                    ),
                    0777,
                    true
                );
            }
            chmod(
                storage_path(
                    'app/public/'.config('app.storage_folder')."/$folder/"
                ),
                0777
            );
        }

        Artisan::call('storage:link');
    }
}
