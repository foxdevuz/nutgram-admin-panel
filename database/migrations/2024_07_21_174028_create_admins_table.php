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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string("chat_id");
            $table->boolean("is_main")->default(false);
            $table->boolean("can_send_ads")->default(false);
            $table->boolean("can_add_admin")->default(false);
            $table->boolean("can_del_admin")->default(false);
            $table->boolean("can_add_channel")->default(false);
            $table->boolean("can_del_channel")->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
