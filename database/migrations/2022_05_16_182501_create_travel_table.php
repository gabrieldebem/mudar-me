<?php

use App\Models\Address;
use App\Models\Driver;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Address::class, 'origin_id');
            $table->foreignIdFor(Address::class, 'destination_id');
            $table->foreignIdFor(Driver::class, 'driver_id');
            $table->float('amount');
            $table->integer('distance_mt');
            $table->timestamp('scheduled_to');
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
        Schema::dropIfExists('travel');
    }
};
