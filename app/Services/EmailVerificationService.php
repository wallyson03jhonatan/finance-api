<?php

namespace App\Services;

use App\Mail\VerifyEmailMailable;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class EmailVerificationService
{
    public function __construct(protected UserRepository $repository)
    {
    }

    public function sendCode(int $userId, string $email): void
    {
        $code = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

        $this->repository->setPendingVerification($userId, $code);

        Mail::to($email)->send(new VerifyEmailMailable($code));
    }

    public function verify(string $code): void
    {
        $user = $this->repository->findByVerificationToken($code);

        if (!$user || !$user->email_verification_sent_at) {
            throw ValidationException::withMessages([
                'code' => 'Código inválido.',
            ]);
        }


        if ($user->email_verification_sent_at->diffInMinutes(now()) > 15) {
            throw ValidationException::withMessages([
                'code' => 'Código expirado. Solicite um novo.',
            ]);
        }

        $this->repository->confirmVerification($user->id);
    }
}