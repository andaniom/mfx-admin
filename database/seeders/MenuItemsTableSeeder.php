<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MenuItem::create([
            'name' => 'Dashboard',
            'url' => '/',
            'route' => 'home.index',
            'order' => 1,
        ]);

        MenuItem::create([
            'name' => 'Task',
            'url' => '/tasks',
            'route' => 'tasks.index',
            'order' => 2,
        ]);

        MenuItem::create([
            'name' => 'Attendance',
            'url' => '/attendance',
            'route' => 'attendance.index',
            'order' => 3,
        ]);

        MenuItem::create([
            'name' => 'Admin',
            'url' => '/admin',
            'route' => 'admin',
            'order' => 4,
        ]);

        MenuItem::create([
            'name' => 'User Management',
            'url' => '/users',
            'route' => 'users.index',
            'parent_id' => 4,
            'order' => 1,
        ]);

        MenuItem::create([
            'name' => 'Attendance Management',
            'url' => '/attendance',
            'route' => 'attendance.admin',
            'parent_id' => 4,
            'order' => 2,
        ]);

        MenuItem::create([
            'name' => 'Post',
            'url' => '/posts',
            'route' => 'posts.index',
            'parent_id' => 4,
            'order' => 3,
        ]);

        MenuItem::create([
            'name' => 'Event',
            'url' => '/events',
            'route' => 'events.index',
            'parent_id' => 4,
            'order' => 4,
        ]);

        MenuItem::create([
            'name' => 'Role',
            'url' => '/roles',
            'route' => 'roles.index',
            'order' => 5,
        ]);
    }
}
