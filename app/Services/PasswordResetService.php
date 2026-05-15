<?php

namespace App\Services;

use App\Mail\PasswordResetMailable;
use App\Repositories\PasswordResetRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class PasswordResetService
{
    public function __construct(
        protected UserRepository $userRepository,
        protected PasswordResetRepository $passwordResetRepository
    ) {
    }

    public function forgot(string $email): void
    {
        $user = $this->userRepository->findByEmail($email);

        // Resposta genérica — não revela se o email existe ou não
        if (!$user)
            return;

        $token = Str::random(64);
        $resetUrl = config('app.frontend_url') . '/reset-password?token=' . $token . '&email=' . urlencode($email);

        $this->passwordResetRepository->store($email, $token);

        Mail::to($email)->send(new PasswordResetMailable($resetUrl));
    }

    public function reset(string $email, string $token, string $newPassword): void
    {
        $record = $this->passwordResetRepository->find($email, $token);

        if (!$record) {
            throw ValidationException::withMessages([
                'token' => 'Token inválido.',
            ]);
        }

        if (Carbon::parse($record->created_at)->diffInMinutes(now()) > 15) {
            throw ValidationException::withMessages([
                'token' => 'Token expirado. Solicite um novo link.',
            ]);
        }

        $user = $this->userRepository->findByEmail($email);

        $user->update(['password' => Hash::make($newPassword)]);
        $user->tokens()->delete();

        $this->passwordResetRepository->delete($email);
    }
}
