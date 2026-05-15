<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class PasswordResetRepository
{
    public function store(string $email, string $token): void
    {
        DB::table('password_resets')->updateOrInsert(
            ['email' => $email],
            ['token' => $token, 'created_at' => Carbon::now()]
        );
    }

    public function find(string $email, string $token): ?object
    {
        return DB::table('password_resets')
            ->where('email', $email)
            ->where('token', $token)
            ->first();
    }

    public function delete(string $email): void
    {
        DB::table('password_resets')->where('email', $email)->delete();
    }
}
