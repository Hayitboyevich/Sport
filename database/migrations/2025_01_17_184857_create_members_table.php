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
        Schema::create('members', function (Blueprint $table) {
            $table->id('member_id');
            $table->bigInteger('member_menu_id')->unsigned();
            $table->string('member_name');
            $table->string('member_photo')->nullable();
            $table->string('member_deputy_name')->comment("lavozim");
            $table->string('member_email')->nullable();
            $table->string('member_phone')->nullable();
            $table->string('member_address')->nullable();
            $table->text('member_content')->nullable();
            $table->text('member_bio')->nullable();
            $table->text('member_function')->nullable();
            $table->integer('member_type')->default(0);
            $table->integer('member_status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
