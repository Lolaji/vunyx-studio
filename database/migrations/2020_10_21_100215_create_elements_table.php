<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateElementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('elements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id');
            $table->string('type');
            $table->string('title');
            $table->text('text');
            $table->tinyInteger('action');
            $table->string('href')->nullable();
            $table->string('link_time')->nullable();
            $table->jsonb('style');
            $table->string('from_time');
            $table->string('to_time');
            $table->string('enter_animate_class')->nullable();
            $table->string('leave_animate_class')->nullable();
            $table->timestamps();

            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('elements');
    }
}
