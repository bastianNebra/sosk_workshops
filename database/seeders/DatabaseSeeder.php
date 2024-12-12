<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Role::factory()->create([
            'name' => 'Admin',
        ]);

        Role::factory()->create([
            'name' => 'Editor',
        ]);

        Role::factory()->create([
            'name' => 'Viewer',
        ]);

         \App\Models\User::factory()->create();

         \App\Models\User::factory()->create([
            'first_name' => 'admin',
            'last_name' => 'admin',
            'email' => 'admin1@admin.com',
            'role_id' => 1
         ]);
        
         \App\Models\User::factory()->create([
            'first_name' => 'Editor',
            'last_name' => 'Editor',
            'email' => 'editor1@editor.com',
            'role_id' => 2
         ]);

         \App\Models\User::factory()->create([
            'first_name' => 'Viewer',
            'last_name' => 'Viewer',
            'email' => 'viewer1@viewer.com',
            'role_id' => 3
         ]);
    }
}
