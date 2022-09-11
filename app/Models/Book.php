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
 *   @OA\Property(property="copies", type="integer"),
 *   @OA\Property(property="published_year", type="integer")
 * )
 */
class Book extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ["title", "author", "publisher", "subject",
        "classification", "copies", "published_year"];

    protected static function boot()
    {
        parent::boot();

        static::updating(function (Book $model) {

            if ($model->in_hand < 0) {
                \Log::error("operation made in_hand below 0:" . $model->id);
                \Log::error("in-hand before:" . $model->in_hand);
                $model->refresh();
                \Log::error("in-hand after:" . $model->in_hand);
                return false;
            }
        });
        static::saving(function (Book $model) {
            \Log::info(["is dirty" => $model->isDirty(), "id" => $model->id]);
        });
    }
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
