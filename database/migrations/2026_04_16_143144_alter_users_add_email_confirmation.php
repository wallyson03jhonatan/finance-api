<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('email_verification_status', ['pending', 'confirmed'])
                  ->default('pending')
                  ->after('email');
            $table->string('email_verification_token', 6)->nullable()->after('email_verification_status');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'email_verification_status',
                'email_verification_token',
            ]);
        });
    }
};