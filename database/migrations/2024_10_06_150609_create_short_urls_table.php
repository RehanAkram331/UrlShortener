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
        Schema::create('short_urls', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('short_url');
            $table->text('original_url');
            $table->Integer('Number_of_clicks')->default(0);
            $table->timestamps();

            
             // Foreign key constraint
            $table->foreign('user_id')
            ->references('id')
            ->on('users')
            ->restrictOnDelete();
        });

       
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('short_urls');
    }
};
