<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table("books")->truncate();
        $this->call([
            GenreSeeder::class,
            BookSeeder::class,
        ]);

    }
}
