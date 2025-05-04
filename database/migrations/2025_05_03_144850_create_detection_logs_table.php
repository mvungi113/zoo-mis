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
        Schema::create('detection_logs', function (Blueprint $table) {
            $table->id();
            $table->string('camera')->nullable();
            $table->string('animal_name');
            $table->string('classification');
            $table->decimal('confidence', 5, 2)->nullable();
            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detection_logs');
    }
};
