<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Book::class;
    protected $genres;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $genre = $this->getRandomGenres();
        return [
            'title' => $this->faker->catchPhrase(),
            'author' => $this->faker->name,
            'publisher' => $this->faker->company,
            'subject' => $genre,
            'classification' => str_pad(rand(0, pow(10, 3) - 1), 3, '0', STR_PAD_LEFT),
            'copies' => rand(1, 10),
        ];
    }
    public function getRandomGenres()
    {
        $genres = \App\Models\Genre::get();
        $genre = $genres->random();
        return $genre->name;
    }

}
