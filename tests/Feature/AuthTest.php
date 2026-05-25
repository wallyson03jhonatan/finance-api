<?php

use App\Mail\VerifyEmailMailable;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

it('logs in with valid credentials', function () {
    User::factory()->create([
        'email' => 'auth@example.com',
        'password' => bcrypt('password123'),
    ]);

    $response = $this->postJson('/api/login', [
        'email' => 'auth@example.com',
        'password' => 'password123',
    ]);

    $response->assertStatus(200)
        ->assertJsonStructure(['access_token', 'token_type', 'user']);
});

it('rejects login with invalid credentials', function () {
    User::factory()->create([
        'email' => 'auth@example.com',
        'password' => bcrypt('correct-password'),
    ]);

    $response = $this->postJson('/api/login', [
        'email' => 'auth@example.com',
        'password' => 'wrong-password',
    ]);

    $response->assertStatus(401);
});

it('registers a user with pending email verification status', function () {
    Mail::fake();

    $response = $this->postJson('/api/register', [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'email_confirmation' => 'john@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertStatus(201);

    $this->assertDatabaseHas('users', [
        'email' => 'john@example.com',
        'email_verification_status' => 'pending',
    ]);

    Mail::assertSent(VerifyEmailMailable::class);
});

it('verifies email with valid code', function () {
    $user = User::factory()->create([
        'email_verification_status' => 'pending',
        'email_verification_token' => '123456',
        'email_verification_sent_at' => now(),
    ]);

    $response = $this->actingAs($user)->postJson('/api/email/verify', [
        'code' => '123456',
    ]);

    $response->assertStatus(200);

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'email_verification_status' => 'confirmed',
    ]);
});

it('rejects expired verification code', function () {
    $user = User::factory()->create([
        'email_verification_status' => 'pending',
        'email_verification_token' => '654321',
        'email_verification_sent_at' => now()->subMinutes(20),
    ]);

    $response = $this->actingAs($user)->postJson('/api/email/verify', [
        'code' => '654321',
    ]);

    $response->assertStatus(422);
});
