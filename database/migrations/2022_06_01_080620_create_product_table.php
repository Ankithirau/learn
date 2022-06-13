<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id('id');
            $table->string('name', 100);
            $table->bigInteger('price');
            $table->text('description');
            $table->text('shortdesc', 100);
            $table->string('image', 50);
            $table->string('date_concert', 100);
            $table->string('sku', 100)->nullable();
            $table->string('pickup_point_id')->nullable();
            $table->string('category_id')->nullable();
            $table->string('counties_id')->nullable();
            $table->bigInteger('event_id')->unsigned()->nullable();
            $table->foreign('event_id')->references('id')->on('events')
                ->onDelete('cascade');
            $table->bigInteger('created_by')->unsigned();
            $table->foreign('created_by')->references('id')->on('users')
                ->onDelete('cascade');
            $table->smallInteger('stock_status')->default(1);
            $table->smallInteger('status')->default(1);
            $table->smallInteger('check_ins_per_ticket')->default(1);
            $table->boolean('allow_ticket_check_out')->default(1);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
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
