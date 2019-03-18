<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropColumnsInProcessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('processes', function (Blueprint $table) {
            $table->dropColumn(['filename', 'owner_id', 'review_due_date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('processes', function (Blueprint $table) {
            $table->string('filename')->after('description');
            $table->integer('owner_id')->unsigned()->after('process_category_id');
            $table->timestamp('review_due_date')->nullable()->after('owner_id');
        });
    }
}
