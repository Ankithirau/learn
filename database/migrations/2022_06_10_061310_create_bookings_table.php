<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_fname')->nullable();
            $table->string('booking_lname')->nullable();
            $table->string('booking_email')->nullable();
            $table->string('booking_phone')->nullable();
            $table->text('booking_info')->nullable();
            $table->date('booking_date');
            $table->decimal('fare_amount', 10, 2);
            $table->decimal('total_amount', 10, 2);
            $table->tinyInteger('number_of_seats')->nullable();
            $table->bigInteger('product_id')->unsigned()->nullable();
            $table->foreign('product_id')->references('id')->on('products')
                ->onDelete('cascade');
            $table->bigInteger('county_id')->unsigned()->nullable();
            $table->foreign('county_id')->references('id')->on('counties')
                ->onDelete('cascade');
            $table->bigInteger('pickup_id')->unsigned()->nullable();
            $table->foreign('pickup_id')->references('id')->on('pickup_points')
                ->onDelete('cascade');
            $table->bigInteger('event_id')->unsigned()->nullable();
            $table->foreign('event_id')->references('id')->on('events')
                ->onDelete('cascade');
            $table->bigInteger('users_id')->unsigned()->nullable();
            $table->foreign('users_id')->references('id')->on('users')
                ->onDelete('cascade');
            // $table->foreignId('transaction_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('coupon_id')->unsigned();
            $table->foreign('coupon_id')->references('id')->on('coupon_code')
                ->onDelete('cascade');
            $table->smallInteger('newsletter_status')->default(1);
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
        Schema::dropIfExists('bookings');
    }
}
