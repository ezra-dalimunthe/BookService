<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class EntityServiceController extends Controller
{
    /**
     * @OA\Get(
     *   tags={"Entity"},
     *   path="/api/v1/entity/book/{id}",
     *   summary="Show a book",
     *   @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     *      @OA\Schema(type="integer")
     *    ),
     *   @OA\Response(
     *     response=200,
     *     description="OK",
     *     @OA\JsonContent(
     *       @OA\Property(ref="#/components/schemas/Book")
     *     ),
     *   ),
     *   @OA\Response(response=404, description="Not Found",
     *       @OA\JsonContent(ref="#/components/schemas/ResourceNotFoundResponse")
     *   ),
     *   @OA\Response(response=403, description="User'rights is insufficient",
     *       @OA\JsonContent(ref="#/components/schemas/ForbiddenResponse")
     *    ),
     * )
     */
    public function showBook(Request $request, $id)
    {
        $model = Book::withTrashed()->findOrFail($id);
        $model->setHidden(["created_at", "deleted_at", "updated_at"]);
        return response()->json(["book" => $model], 200);
    }

    /**
     * @OA\Get(
     *   tags={"Entity"},
     *   path="/api/v1/entity/books",
     *   summary="Summary",
     *   @OA\Parameter(
     *      name="ids",
     *      in="query",
     *      required=true,
     *      @OA\Schema(type="string")
     *    ),
     *   @OA\Response(response=200, description="OK"),
     * )
     */
    public function showBooks(Request $request)
    {
        $ids = $request->input("ids");
        $ids = explode(",", $ids);

        $models = Book::withTrashed()->whereIn("id", $ids)
            ->get(["id","title", "author", "publisher","classification", "subject","published_year"]);
        return response()->json(["books" => $models], 200);
    }
}
