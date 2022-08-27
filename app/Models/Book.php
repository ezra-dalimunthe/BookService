<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *   schema="Book",
 *   @OA\Property(property="title", type="string"),
 *   @OA\Property(property="author", type="string"),
 *   @OA\Property(property="publisher", type="string"),
 *   @OA\Property(property="subject", type="string"),
 *   @OA\Property(property="classification", type="string"),
 *   @OA\Property(property="copies", type="string")
 * )
 */
class Book extends Model
{
    use HasFactory;
    protected $fillable = ["title", "author", "publisher", "subject",
        "classification", "copies"];
    public static function getDefaultValidator()
    {
        return [
            "title" => "required|string|max:100",
            "author" => "required|string|max:100",
            "publisher" => "required|string|max:100",
            "subject" => "required|string|max:200",
            "classification" => "required|string|max:10",
            "copies" => "required|integer",
        ];
    }
}
