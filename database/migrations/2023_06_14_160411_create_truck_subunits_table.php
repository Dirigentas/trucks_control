<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('truck_subunits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('main_truck_id');
            $table->string('main_truck', 255)->required();
            $table->string('subunit', 255)->required();
            $table->date('start_date')->required();
            $table->date('end_date')->required();
            $table->timestamps();
            $table->foreign('main_truck_id')->references('id')->on('trucks')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('truck_subunits');
    }
};
