<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *   schema="Genre",
 *   @OA\Property(property="name", type="string"),
 * )
 */
class Genre extends Model
{
    protected $fillable = ["name"];
    protected $hidden = ['created_at', "updated_at"];
}
