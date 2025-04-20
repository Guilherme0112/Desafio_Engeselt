<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterConfectioneryTableColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('confectioneries', function (Blueprint $table) {

            DB::statement('ALTER TABLE confectioneries ALTER COLUMN latitude TYPE decimal(10,6) USING latitude::decimal(10,6)');
            DB::statement('ALTER TABLE confectioneries ALTER COLUMN longitude TYPE decimal(10,6) USING longitude::decimal(10,6)');
        });
    }

    /**
     * Revert the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('confectioneries', function (Blueprint $table) {

            DB::statement('ALTER TABLE confectioneries ALTER COLUMN latitude TYPE varchar USING latitude::varchar');
            DB::statement('ALTER TABLE confectioneries ALTER COLUMN longitude TYPE varchar USING longitude::varchar');
        });
    }
}
