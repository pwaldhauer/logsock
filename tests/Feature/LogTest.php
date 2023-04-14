<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Log;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use PwaBlui\Models\User;
use Tests\TestCase;

class LogTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');
        $response->assertRedirectToRoute('login.auth');
    }

    public function test_log_list(): void
    {
        [$logA] = Log::factory(10)->create();
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/');
        $response->assertStatus(200);
        $response->assertSee($logA->topic);
    }

    public function test_push_log(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;

        $payload = [
            'topic' => 'test',
            'message' => 'message',
        ];

        $this->postJson('/api/', $payload)
            ->assertStatus(401);

        $this->postJson('/api/', $payload, ['Authorization' => 'Bearer '.$token])
            ->assertStatus(200);

        $this->assertDatabaseHas('logs', [
            'level' => 3,
            'topic' => 'test',
            'payload' => json_encode(['message' => 'message']),
        ]);
    }
}
