<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class StatisticController extends Controller
{

    /**
     * @OA\Get(
     *   tags={"Statistic"},
     *   path="/api/v1/statistic/books-on-hand",
     *   summary="Get number book group by on hand",
     *   @OA\Response(response=200, description="OK"),
     * )
     */
    public function booksOnHand(Request $request)
    {
        $copies = (int) Book::sum("copies");
        $inhand = (int) Book::sum("in_hand");
        $rvalue = ["copies" => $copies, "inhand" => $inhand, "outhand" => $copies - $inhand];
        return response()->json($rvalue);

    }

}
