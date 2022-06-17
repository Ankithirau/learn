<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateEventScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_schedule', function (Blueprint $table) {
            $table->id();
            $table->string('starting_point', 100);
            $table->string('destination', 100);
            $table->date('schedule_date');
            $table->time('departure_time');
            $table->decimal('bus_lat', 10, 7);
            $table->decimal('bus_lng', 10, 7);
            $table->bigInteger('pickup_point_id')->unsigned();
            $table->foreign('pickup_point_id')->references('id')->on('pickup_points')
                ->onDelete('cascade');
            $table->bigInteger('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products')
                ->onDelete('cascade');
            $table->bigInteger('bus_id')->unsigned();
            $table->foreign('bus_id')->references('id')->on('bus_details')
                ->onDelete('cascade');
            $table->bigInteger('created_by')->unsigned();
            $table->foreign('created_by')->references('id')->on('users')
                ->onDelete('cascade');
            $table->smallInteger('status')->default(1);
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
        Schema::dropIfExists('event_schedule');
    }
}
