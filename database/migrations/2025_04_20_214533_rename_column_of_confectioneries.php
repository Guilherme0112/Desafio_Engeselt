<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('confectioneries', function (Blueprint $table) {
            $table->renameColumn('name', 'confectionery');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('confectioneries', function (Blueprint $table) {
            $table->renameColumn('confectionery', 'name');
        });
    }
};
