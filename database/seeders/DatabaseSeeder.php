<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Branch;
use App\Models\Caliber;
use App\Models\Employee;
use App\Models\Store;
use App\Models\System;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
     
        $user_data = [
            'id'=>1,
            'name' => 'admin',
            'email' => 'admin@.tech',
            'password' => Hash::make('123456'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];

        $user =User::updateOrCreate(['id'=>1],$user_data);
        
        // $this->call([
        // ]);
    }
}
