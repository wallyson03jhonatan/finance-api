<?php

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

it('blocks unauthenticated access to protected routes', function () {
    $response = $this->getJson('/api/me');

    $response->assertStatus(401);
});

it('blocks unverified users from accessing protected routes', function () {
    $user = User::factory()->create([
        'email_verification_status' => 'pending',
    ]);

    $response = $this->actingAs($user)->getJson('/api/me');

    $response->assertStatus(403);
});

it('resets password with valid token', function () {
    $user = User::factory()->create([
        'email' => 'reset@example.com',
        'password' => bcrypt('old-password'),
    ]);

    $token = Str::random(64);

    DB::table('password_resets')->insert([
        'email' => 'reset@example.com',
        'token' => $token,
        'created_at' => now(),
    ]);

    $response = $this->postJson('/api/password/reset', [
        'email' => 'reset@example.com',
        'token' => $token,
        'password' => 'new-password-123',
        'password_confirmation' => 'new-password-123',
    ]);

    $response->assertStatus(200);

    $this->assertDatabaseMissing('password_resets', [
        'email' => 'reset@example.com',
    ]);
});

it('rejects password reset with invalid token', function () {
    User::factory()->create([
        'email' => 'reset@example.com',
    ]);

    $response = $this->postJson('/api/password/reset', [
        'email' => 'reset@example.com',
        'token' => 'completely-invalid-token',
        'password' => 'new-password-123',
        'password_confirmation' => 'new-password-123',
    ]);

    $response->assertStatus(422);
});
