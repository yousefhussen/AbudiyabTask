<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->index(['car_id', 'start_date', 'end_date']);
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['car_id', 'start_date', 'end_date']);
        });
    }
};
