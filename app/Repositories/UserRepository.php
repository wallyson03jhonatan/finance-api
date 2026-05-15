<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;



class UserRepository
{
    public function updateInfo(int $userId, array $data): User
    {
        $user = User::findOrFail($userId);
        $user->update($data);

        return $user->refresh();
    }

    public function updatePassword(int $userId, string $newPassword): void
    {
        $user = User::findOrFail($userId);
        $user->update(['password' => Hash::make($newPassword)]);
    }


    public function setPendingVerification(int $userId, string $code): void
    {
        User::where('id', $userId)->update([
            'email_verification_status' => 'pending',
            'email_verification_token' => $code,
            'email_verified_at' => null,
            'email_verification_sent_at' => Carbon::now(),
        ]);
    }

    public function confirmVerification(int $userId): void
    {
        User::where('id', $userId)->update([
            'email_verification_status' => 'confirmed',
            'email_verification_token' => null,
            'email_verified_at' => Carbon::now(),
        ]);
    }

    public function findByVerificationToken(string $code): ?User
    {
        return User::where('email_verification_token', $code)->first();
    }

    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }
}
