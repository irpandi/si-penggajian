<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        User::truncate();
        Schema::enableForeignKeyConstraints();

        // for ($i = 0; $i < 100; $i++) {
        //     User::create([
        //         'name'       => 'Rifki',
        //         'username'   => 'rifki',
        //         'email'      => Str::random(10) . '@gmail.com',
        //         'password'   => Hash::make('password'),
        //         'created_by' => 'admin',
        //         'created_at' => Carbon::Now(),
        //     ]);
        // }
    }
}
