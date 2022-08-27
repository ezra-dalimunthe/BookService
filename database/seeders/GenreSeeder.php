<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $genres = ["Classic", "Comic/Graphic Novel", "Crime/Detective", "Fable", "Fairy tale", "Fanfiction",
            "Fantasy", "Fiction narrative", "Fiction in verse", "Folklore", "Historical fiction", "Horror",
            "Humor", "Legend", "Metafiction", "Mystery", "Mythology", "Mythopoeia", "Realistic fiction", "Science fiction", "Short story", "Suspense/Thriller", "Tall tale", "Western", "Biography/Autobiography",
            "Essay", "Narrative nonfiction", "Speech", "Textbook", "Reference book"];

        foreach ($genres as $value) {
            Genre::updateOrCreate(["name" => $value], ["name" => $value]);
        }
    }
}
