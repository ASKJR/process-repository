<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsInProcessReviewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('process_review', function (Blueprint $table) {
            $table->integer('owner_id')->after('created_by')->unsigned();
            $table->timestamp('review_due_date')->after('owner_id');
            $table->softDeletes();
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
            $table->dropColumn(['owner_id', 'review_due_date']);
            $table->dropSoftDeletes();
        });
    }
}
