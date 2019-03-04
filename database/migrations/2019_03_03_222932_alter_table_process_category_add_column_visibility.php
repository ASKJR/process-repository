<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableProcessCategoryAddColumnVisibility extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('process_category', function (Blueprint $table) {
            $table->enum('visibility', ['public', 'restricted'])->after('permission');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('process_category', function (Blueprint $table) {
            $table->dropColumn('visibility');
        });
    }
}
