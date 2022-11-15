<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class InterServiceController extends Controller
{
    /**
     * @OA\Put(
     *   tags={"Inter Service"},
     *   path="/api/v1/inter-service/book-inhand/{id}",
     *   summary="update book inhand data",
     *   @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     *      @OA\Schema(type="integer")
     *    ),
     *    @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *       allOf={
     *          @OA\Schema(ref="#/components/schemas/BookInhand")
     *       },
     *      )
     *    ),
     *   @OA\Response(response=200, description="OK"),
     * )
     */
    public function bookInhand(Request $request, $id)
    {

        $this->validate($request, [
            "book_id" => "required|integer|min:0",
            "operation" => ["required", "in:increment,decrement"],
        ]);

        $book = Book::withTrashed()->findOrFail($id);

        switch ($request->input("operation")) {
            case "increment":
                $book->in_hand += 1;
                break;
            case "decrement":
                $book->in_hand -= 1;
        }
        $isDirty = $book->isDirty();
        $saved = $book->save();


        if ($saved) {
            return response()->json(["operation" => "succeed"], 201);
        }
        return response()->json(["operation" => "fail", "reason" => "Data not changed:" . $saved], 400);

    }
}
