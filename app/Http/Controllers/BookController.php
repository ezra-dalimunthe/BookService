<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Auth;
use Illuminate\Http\Request;

class BookController extends Controller
{
    use AuthorizationTrait;
    /**
     * @OA\Get(
     *   tags={"Book"},
     *   path="/api/v1/books",
     *   security={{ "apiAuth": {} }},
     *   summary="Book index",
     *    @OA\Parameter( name="page", in="query", required=false,
     *        description="expected page number", @OA\Schema(type="integer")
     *    ),
     *    @OA\Parameter( name="per-page", in="query", required=false,
     *        description="number of items on page", @OA\Schema(type="integer")
     *    ),
     *    @OA\Parameter( name="search", in="query", required=false,
     *        description="search by keyword", @OA\Schema(type="string")
     *    ),
     *    @OA\Response(
     *        response=200,
     *        description="OK",
     *        @OA\JsonContent(
     *            allOf={ @OA\Schema(ref="#/components/schemas/data-pagination") },
     *            @OA\Property(
     *                property="models",
     *                type="array",
     *                @OA\Items(
     *                    allOf={
     *                        @OA\Schema(ref="#/components/schemas/AutoIncrement"),
     *                        @OA\Schema(ref="#/components/schemas/Book"),
     *                    }
     *                ),
     *            )
     *        ),
     *    ),
     *    @OA\Response(response=403, description="Forbidden",
     *        @OA\JsonContent(ref="#/components/schemas/ForbiddenResponse")
     *    ),
     *    @OA\Response(response=404, description="Not Found",
     *        @OA\JsonContent(ref="#/components/schemas/ResourceNotFoundResponse")
     *    )
     * )
     */
    public function index(Request $request)
    {
        $this->allowRole(["book_manager","front_desk"]);
        $models = $this->query($request, 0);
        return response()->json($models);
    }

    /**
     * @OA\Post(
     *   tags={"Book"},
     *   path="/api/v1/book",
     *   security={{ "apiAuth": {} }},
     *   summary="Book store",
     *    @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *       allOf={
     *          @OA\Schema(ref="#/components/schemas/Book")
     *       },
     *      )
     *    ),
     *    @OA\Response(
     *      response=201,
     *      description="OK",
     *      @OA\JsonContent(
     *       allOf={
     *          @OA\Schema(ref="#/components/schemas/data_manipulation_response"),
     *       },
     *       @OA\Property(property="model", type="object",
     *          allOf={
     *            @OA\Schema(ref="#/components/schemas/AutoIncrement"),
     *             @OA\Schema(ref="#/components/schemas/Book"),
     *          }
     *       )
     *      )
     *    ),
     *    @OA\Response(response=403, description="Forbidden",
     *       @OA\JsonContent(ref="#/components/schemas/ForbiddenResponse")
     *    )
     * )
     */
    public function store(Request $request)
    {
        $this->allowRole(["book_manager"]);
        $this->validate($request, Book::getDefaultValidator());
        $book = Book::create([
            "title" => $request->input("title"),
            "author" => $request->input("author"),
            "publisher" => $request->input("publisher"),
            "classification" => $request->input("classification"),
            "subject" => $request->input("subject"),
            "copies" => $request->input("copies"),
            "published_year" => $request->input("published_year"),
        ]);

        return response()->json([
            "message" => "New book saved successfully!",
            "model" => $book,
        ], 201);
    }

    /**
     * @OA\Put(
     *   tags={"Book"},
     *   path="/api/v1/book/{id}",
     *   security={{ "apiAuth": {} }},
     *   summary="Book update",
     *    @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     *      @OA\Schema(type="integer")
     *    ),
     *    @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *       allOf={
     *          @OA\Schema(ref="#/components/schemas/AutoIncrement"),
     *          @OA\Schema(ref="#/components/schemas/Book")
     *       },
     *      )
     *    ),
     *    @OA\Response(
     *      response=200,
     *      description="OK",
     *      @OA\JsonContent(
     *       allOf={
     *          @OA\Schema(ref="#/components/schemas/data_manipulation_response"),
     *       },
     *       @OA\Property(property="model", type="object",
     *          allOf={
     *            @OA\Schema(ref="#/components/schemas/AutoIncrement"),
     *             @OA\Schema(ref="#/components/schemas/Book"),
     *          }
     *       )
     *      )
     *    ),
     *    @OA\Response(response=403, description="Forbidden",
     *       @OA\JsonContent(ref="#/components/schemas/ForbiddenResponse")
     *    )
     * )
     */
    public function update(Request $request, $id)
    {
        $this->allowRole(["book_manager"]);
        $this->validate($request, Book::getDefaultValidator());

        $book = Book::findOrFail($id);

        $book->update([
            "title" => $request->input("title"),
            "author" => $request->input("author"),
            "publisher" => $request->input("publisher"),
            "classification" => $request->input("classification"),
            "subject" => $request->input("subject"),
            "copies" => $request->input("copies"),
            "published_year" => $request->input("published_year"),
        ]);
        return response()->json([
            "message" => "Book updated successfully!",
            "model" => $book,
        ], 200);
    }

    /**
     * @OA\Get(
     *   tags={"Book"},
     *   path="/api/v1/book/{id}",
     *   security={{ "apiAuth": {} }},
     *   summary="Book show",
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
    public function show(Request $request, $id)
    {
        $this->allowRole(["book_manager"]);
        $book = Book::findOrFail($id);
        return response()->json(["book" => $book], 200);
    }

    /**
     * @OA\Delete(
     *   tags={"Book"},
     *   path="/api/v1/book/{id}",
     *   security={{ "apiAuth": {} }},
     *   summary="Book destroy",
     *    @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     *      @OA\Schema(type="integer")
     *    ),
     *   @OA\Response(
     *     response=204,
     *     description="OK"
     *   ),
     *    @OA\Response(response=403, description="Forbidden",
     *       @OA\JsonContent(ref="#/components/schemas/ForbiddenResponse")
     *    )
     * )
     */
    public function destroy(Request $request, $id)
    {
        $this->allowRole(["book_manager"]);
        $book = Book::find($id);
        if ($book) {
            $book->delete();
        }
        return response()->json(null, 204);
    }

    private function query(Request $request, $type = 0)
    {
        $sortBy = $request->input("sort-by", "title");
        $sortDir = $request->input("sort-dir", "asc");
        $perPage = $request->input("per-page", 20);
        $search = $request->input("search", null);

        $models = null;

        switch ($type) {
            case 0:
                $models = new Book;
                break;
            case 1:
                $models = Book::onlyTrashed();
                break;
            case 2:
                $models = Book::withTrashed();
        }

        $models = $models->orderBy($sortBy, $sortDir);

        if ($search) {
            $params = json_decode($search, true);
            $field = strtolower(key($params));
            $value = current($params);
            switch ($field) {
                default:
                    $models->where($field, 'like', "%" . $value . '%');
            }

        }

        $models = $models->paginate($perPage);

        return $models;
    }
}
