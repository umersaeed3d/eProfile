<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMergedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mergeds', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('name',225);
            $table->string('title',100);
            $table->string('client_name',100);
            $table->string('sr_no',6);
            $table->string('due_date',100);
            $table->timestamp('date');
            $table->integer('workstation_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mergeds');
    }
}
