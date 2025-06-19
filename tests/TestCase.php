<?php

namespace Tests;

use Illuminate\Foundation\Testing\{RefreshDatabase, TestCase as BaseTestCase};
use Illuminate\Foundation\Testing\WithFaker;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        // Clear any cached data for tests
        $this->artisan('cache:clear');
    }

    /**
     * Create an authenticated user for testing
     */
    protected function createAuthenticatedUser(array $attributes = []): \App\Models\User
    {
        $user = \App\Models\User::factory()->create($attributes);
        $this->actingAs($user);

        return $user;
    }

    /**
     * Create an admin user for testing
     */
    protected function createAdminUser(array $attributes = []): \App\Models\User
    {
        $user = $this->createAuthenticatedUser($attributes);
        $user->assignRole('admin');

        return $user;
    }
}
