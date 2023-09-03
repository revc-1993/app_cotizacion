<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dashboard = Menu::create([
            'name' => 'dashboard',
            'route_or_url' => 'dashboard',
            'icon' => 'tachometer-alt',
            'active' => true,
            'position' => 1,
            'routes' => ['dashboard'],
            'deleteable' => false,
        ]);

        $builtin = Menu::create([
            'name' => 'configuración',
            'route_or_url' => '#',
            'icon' => 'cogs',
            'active' => true,
            'position' => 2,
            'routes' => [
                'superuser.configuration.profile',
                'superuser.configuration.mail',
                'superuser.user.index',
                'superuser.user.create',
                'superuser.user.edit',
                'superuser.user.profile',
                'superuser.role.index',
                'superuser.role.create',
                'superuser.role.edit',
                'superuser.permission.index',
                'superuser.menu.index',
                'superuser.menu.edit',
            ],
            'deleteable' => false,
        ]);

        $builtin->permissions()->attach([
            // Permission::where('name', 'save company configuration')->first()->id,
            Permission::where('name', 'create user')->first()->id,
            Permission::where('name', 'read user')->first()->id,
            Permission::where('name', 'update user')->first()->id,
            Permission::where('name', 'delete user')->first()->id,
            Permission::where('name', 'create role')->first()->id,
            Permission::where('name', 'read role')->first()->id,
            Permission::where('name', 'update role')->first()->id,
            Permission::where('name', 'delete role')->first()->id,
            Permission::where('name', 'create permission')->first()->id,
            Permission::where('name', 'read permission')->first()->id,
            Permission::where('name', 'update permission')->first()->id,
            Permission::where('name', 'delete permission')->first()->id,
            Permission::where('name', 'create menu')->first()->id,
            Permission::where('name', 'read menu')->first()->id,
            Permission::where('name', 'update menu')->first()->id,
            Permission::where('name', 'delete menu')->first()->id,
        ]);

        $company = $builtin->childs()->create([
            'name' => 'company',
            'route_or_url' => 'superuser.configuration.profile',
            'icon' => 'building',
            'active' => true,
            'position' => 1,
            'routes' => [
                'superuser.configuration.profile',
            ],
            'deleteable' => false,
        ]);

        $mailServer = $builtin->childs()->create([
            'name' => 'mail server',
            'route_or_url' => 'superuser.configuration.mail',
            'icon' => 'envelope',
            'active' => true,
            'position' => 2,
            'routes' => [
                'superuser.configuration.mail',
            ],
            'deleteable' => false,
        ]);

        // $company->permissions()->attach([
        //     Permission::where('name', 'save company configuration')->first()->id,
        // ]);

        $user = $builtin->childs()->create([
            'name' => 'user',
            'route_or_url' => 'superuser.user.index',
            'icon' => 'user',
            'active' => true,
            'position' => 3,
            'routes' => [
                'superuser.user.index',
                'superuser.user.create',
                'superuser.user.edit',
                'superuser.user.profile',
            ],
            'deleteable' => false,
        ]);

        $user->permissions()->attach([
            Permission::where('name', 'create user')->first()->id,
            Permission::where('name', 'read user')->first()->id,
            Permission::where('name', 'update user')->first()->id,
            Permission::where('name', 'delete user')->first()->id,
        ]);

        $permission = $builtin->childs()->create([
            'name' => 'permission',
            'route_or_url' => 'superuser.permission.index',
            'icon' => 'key',
            'active' => true,
            'position' => 4,
            'routes' => [
                'superuser.permission.index',
            ],
            'deleteable' => false,
        ]);

        $permission->permissions()->attach([
            Permission::where('name', 'create permission')->first()->id,
            Permission::where('name', 'read permission')->first()->id,
            Permission::where('name', 'update permission')->first()->id,
            Permission::where('name', 'delete permission')->first()->id,
        ]);

        $roles = $builtin->childs()->create([
            'name' => 'roles',
            'route_or_url' => 'superuser.role.index',
            'icon' => 'users',
            'active' => true,
            'position' => 5,
            'routes' => [
                'superuser.role.index',
                'superuser.role.create',
                'superuser.role.edit',
            ],
            'deleteable' => false,
        ]);

        $roles->permissions()->attach([
            Permission::where('name', 'create role')->first()->id,
            Permission::where('name', 'read role')->first()->id,
            Permission::where('name', 'update role')->first()->id,
            Permission::where('name', 'delete role')->first()->id,
        ]);

        $menu = $builtin->childs()->create([
            'name' => 'menu',
            'route_or_url' => 'superuser.menu.index',
            'icon' => 'bars',
            'active' => true,
            'position' => 6,
            'routes' => [
                'superuser.menu.index',
                'superuser.menu.edit',
            ],
            'deleteable' => false,
        ]);

        $menu->permissions()->attach([
            Permission::where('name', 'create menu')->first()->id,
            Permission::where('name', 'read menu')->first()->id,
            Permission::where('name', 'update menu')->first()->id,
            Permission::where('name', 'delete menu')->first()->id,
        ]);

        // FLDSFÑLDSKFÑLDSFKÑSÑF

        $customer = Menu::create([
            'name' => 'clientes',
            'route_or_url' => '#',
            'icon' => 'briefcase',
            'active' => true,
            'position' => 3,
            'routes' => [
                'customers.index',
                'customers.create',
                'customers.store',
                'customers.edit',
                'customers.update',
                'customers.destroy'
            ],
            'deleteable' => true,
        ]);

        $customer->childs()->create([
            'name' => 'nuevo cliente',
            'route_or_url' => 'customers.create',
            'icon' => 'user-plus',
            'active' => true,
            'position' => 1,
            'routes' => [
                'customers.create',
            ],
            'deleteable' => false,
        ]);

        $customer->childs()->create([
            'name' => 'todos los clientes',
            'route_or_url' => 'customers.index',
            'icon' => 'table',
            'active' => true,
            'position' => 2,
            'routes' => [
                'customers.index',
                'customers.store',
                'customers.edit',
                'customers.update',
                'customers.destroy'
            ],
            'deleteable' => false,
        ]);

        // DSFDSFKSFKSLKLFLFSLFDSL

        $quote = Menu::create([
            'name' => 'cotizaciones',
            'route_or_url' => '#',
            'icon' => 'wallet',
            'active' => true,
            'position' => 4,
            'routes' => [
                'quotes.index',
                'quotes.create',
                'quotes.store',
                'quotes.edit',
                'quotes.update',
                'quotes.destroy'
            ],
            'deleteable' => true,
        ]);

        $quote->childs()->create([
            'name' => 'nueva cotización',
            'route_or_url' => 'quotes.create',
            'icon' => 'square-plus',
            'active' => true,
            'position' => 1,
            'routes' => [
                'quotes.create',
            ],
            'deleteable' => false,
        ]);

        $quote->childs()->create([
            'name' => 'todas las cotizaciones',
            'route_or_url' => 'quotes.index',
            'icon' => 'table',
            'active' => true,
            'position' => 2,
            'routes' => [
                'quotes.index',
                'quotes.store',
                'quotes.edit',
                'quotes.update',
                'quotes.destroy'
            ],
            'deleteable' => false,
        ]);

        $bill = Menu::create([
            'name' => 'cobros',
            'route_or_url' => 'bills.index',
            'icon' => 'hand-holding-dollar',
            'active' => true,
            'position' => 5,
            'routes' => ['bills.index', 'quotes.markAsBilled'],
            'deleteable' => false,
        ]);

        $report = Menu::create([
            'name' => 'reportes',
            'route_or_url' => 'reports',
            'icon' => 'square-poll-vertical',
            'active' => true,
            'position' => 6,
            'routes' => ['reports.index'],
            'deleteable' => false,
        ]);
    }
}
