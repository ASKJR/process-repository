<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameColumnUserIdInProcessReviewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('process_review', function (Blueprint $table) {
            $table->renameColumn('user_id', 'created_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('process_review', function (Blueprint $table) {
            $table->renameColumn('created_by', 'user_id');
        });
    }
}
