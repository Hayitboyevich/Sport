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
        Schema::create('kafedras', function (Blueprint $table) {
            $table->id('kafedra_id');
            $table->integer('kafedra_menu_id');
            $table->text('kafedra_name');
            $table->text('kafedra_name_ru')->nullable();
            $table->text('kafedra_name_en')->nullable();
            $table->text('kafedra_about')->nullable();
            $table->integer('kafedra_status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kafedras');
    }
};
