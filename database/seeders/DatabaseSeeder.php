<?php

namespace Database\Seeders;

use App\Models\Listing;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = User::factory()->create([  // create 1 dummy user
          'name' => 'Tony Stark',
          'email' => 'tstark@starkindustries.com'
        ]);

        Listing::factory(6)->create([
          'user_id' => $user->id
        ]);
    }
}