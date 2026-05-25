<?php

use App\Models\Categories;
use App\Models\Transactions;
use App\Models\User;

it('creates a category for authenticated verified user', function () {
    $user = User::factory()->create([
        'email_verification_status' => 'confirmed',
    ]);

    $response = $this->actingAs($user)->postJson('/api/categories', [
        'name' => 'Food',
        'description' => 'Food expenses',
    ]);

    $response->assertStatus(201);

    $this->assertDatabaseHas('categories', [
        'user_id' => $user->id,
        'name' => 'Food',
    ]);
});

it('prevents deleting a category linked to a transaction', function () {
    $user = User::factory()->create([
        'email_verification_status' => 'confirmed',
    ]);

    $category = Categories::factory()->create([
        'user_id' => $user->id,
        'name' => 'Linked Category',
    ]);

    Transactions::factory()->create([
        'user_id' => $user->id,
        'category_id' => $category->id,
        'description' => 'Some expense',
        'value' => 100.00,
        'registerType' => 'outcome',
    ]);

    $response = $this->actingAs($user)->deleteJson("/api/categories/{$category->id}");

    $response->assertStatus(422);

    $this->assertDatabaseHas('categories', [
        'id' => $category->id,
    ]);
});
