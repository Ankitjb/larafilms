<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('films', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->date('release_date')->nullable();
            $table->enum('rating',[ 1, 2, 3, 4, 5] )->comment('1=>Very poor,2=>Poor,3=>Average,4=>Good,5=>Excellent');
            $table->decimal('ticket_price')->default('0.0');
            $table->mediumInteger('country_id')->nullable();
            $table->string('photo')->nullable();
            $table->integer('user_id');
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
        Schema::dropIfExists('films');
    }
}
