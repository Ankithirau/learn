<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->bigInteger('total_seat')->nullable()->after('status');
            $table->bigInteger('booked_seat')->nullable()->after('status');
            $table->text('meta_desc')->nullable()->after('sku');
            $table->string('meta_tag')->nullable()->after('sku');
            $table->string('meta_title')->nullable()->after('sku');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['total_seat', 'booked_seat', 'meta_title', 'meta_tag', 'meta_desc']);
        });
    }
}
