<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *   schema="Book",
 *   @OA\Property(property="title", type="string"),
 *   @OA\Property(property="author", type="string"),
 *   @OA\Property(property="publisher", type="string"),
 *   @OA\Property(property="subject", type="string"),
 *   @OA\Property(property="classification", type="string"),
 *   @OA\Property(property="copies", type="integer")
 *   @OA\Property(property="published_year", type="integer")
 * )
 */
class Book extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ["title", "author", "publisher", "subject",
        "classification", "copies","published_year"];

    //protected $hidden = ["created_at", "deleted_at", "updated_at"];
    public static function getDefaultValidator()
    {
        return [
            "title" => "required|string|max:100",
            "author" => "required|string|max:100",
            "publisher" => "required|string|max:100",
            "subject" => "required|string|max:200",
            "classification" => "required|string|max:10",
            "copies" => "required|integer",
            "published_year" => "required|integer",
        ];
    }
}
