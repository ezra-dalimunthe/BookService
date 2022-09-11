<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn("books", "in_hand")) //check the column
        {
            Schema::table('books', function (Blueprint $table) {
                $table->integer('in_hand')->after("copies")->default(1);
            });
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        if (Schema::hasColumn("books", "in_hand")) //check the column
        {
            Schema::table('books', function (Blueprint $table) {
                $table->dropColumn('in_hand');
            });
        }

    }
}
