<?php

namespace Database\Seeders;

use App\Enums\Role as EnumsRole;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            // Admin permissions
            'view users',
            'create users',
            'update users',
            'delete users',
            'create services',
            'update services',
            'delete services',
            'view appointments',
            // Owner permissions - TODO: More permissions like: view analytics, manage money, etc.
            'manage barbershop',
            // Barber permissions
            'set working hours',
            // Shared permissions (barber - customer)
            'view own appointments',
            'reschedule own appointments',
            // Customer permissions
            'view services',
            'book appointments',
            'delete own appointments',
            'cancel own appointments',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $admin = Role::findOrCreate(EnumsRole::Admin->value);
        $barber = Role::findOrCreate(EnumsRole::Barber->value);
        $customer = Role::findOrCreate(EnumsRole::Customer->value);
        $owner = Role::findOrCreate(EnumsRole::Owner->value);

        $owner->givePermissionTo(Permission::all());

        $admin->givePermissionTo([
            'view users',
            'create users',
            'update users',
            'delete users',
            'create services',
            'update services',
            'delete services',
            'view appointments',
        ]);

        $barber->givePermissionTo([
            'set working hours',
            'view own appointments',
            'reschedule own appointments',
        ]);

        $customer->givePermissionTo([
            'view own appointments',
            'reschedule own appointments',
            'view services',
            'book appointments',
            'delete own appointments',
            'cancel own appointments',
        ]);
    }
}
