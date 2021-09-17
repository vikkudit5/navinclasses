<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('admin_id');
            $table->string('name');           
            $table->enum('type', ['course','testseries','books']);
            $table->string('short_desc');            
            $table->text('description');
            $table->string('video_url');
            $table->string('features');
            $table->string('image');
            $table->string('slug');
            $table->integer('sort_order');
            $table->enum('status',array('1','0'))->nullable()->change();
            $table->enum('status', ['1', '0']);
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
        Schema::dropIfExists('products');
    }
}
