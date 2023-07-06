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
            'name' => 'builtin',
            'route_or_url' => '#',
            'icon' => 'cogs',
            'active' => true,
            'position' => 2,
            'routes' => [
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

        $user = $builtin->childs()->create([
            'name' => 'user',
            'route_or_url' => 'superuser.user.index',
            'icon' => 'user',
            'active' => true,
            'position' => 1,
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
            'position' => 2,
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
            'position' => 3,
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
            'position' => 4,
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
            'name' => 'importadores',
            'route_or_url' => '#',
            'icon' => 'rectangle-list',
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

        $new_customer = $customer->childs()->create([
            'name' => 'nuevo cliente',
            'route_or_url' => 'customers.create',
            'icon' => 'customer',
            'active' => true,
            'position' => 1,
            'routes' => [
                'customers.create',
            ],
            'deleteable' => false,
        ]);

        $customers = $customer->childs()->create([
            'name' => 'todos los clientes',
            'route_or_url' => 'customers.index',
            'icon' => 'customer',
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
            'icon' => 'rectangle-list',
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

        $new_quote = $quote->childs()->create([
            'name' => 'nueva cotización',
            'route_or_url' => 'quotes.create',
            'icon' => 'user',
            'active' => true,
            'position' => 1,
            'routes' => [
                'quotes.create',
            ],
            'deleteable' => false,
        ]);

        $quotes = $quote->childs()->create([
            'name' => 'todas las cotizaciones',
            'route_or_url' => 'quotes.index',
            'icon' => 'user',
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
    }
}
