<?php

namespace Tests\Unit;

use App\Models\Team;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Support\Str;

class APITest extends TestCase
{
    public function testUserCreation()
    {
        $response = $this->json('POST', '/api/register', [
            'name' => 'Ellipsis User',
            'email' => Str::random(10) . '@ellipsis.com',
            'password' => '12345',
        ]);

        $response->assertStatus(200)->assertJsonStructure([
            'success' => ['token', 'name']
        ]);
    }

    public function testUserLogin()
    {
        $response = $this->json('POST', '/api/login', [
            'email' => 'ellipsis@ellipsis.com',
            'password' => '_ec2_fa$#'
        ]);

        $response->assertStatus(200)->assertJsonStructure([
            'success' => ['token']
        ]);
    }

    public function testTeamFetch()
    {
        $user = User::find(1);

        $response = $this->actingAs($user, 'api')
            ->json('GET', '/api/teams')
            ->assertStatus(200)->assertJsonStructure([
                '*' => [
                    'id',
                    'name',
                    'created_at',
                    'updated_at',
                    'deleted_at'
                ]
            ]);
    }

    public function testTeamCreation()
    {
        $this->withoutMiddleware();

        $response = $this->json('POST', '/api/teams', [
            'name' => Str::random(10),
        ]);

        $response->assertStatus(200)->assertJson([
            'status' => true,
            'message' => 'Team Created'
        ]);
    }

    public function testTeamDeletion()
    {
        $user = User::find(1);

        $team = Team::create(['name' => 'Ellipsis deleted item']);

        $response = $this->actingAs($user, 'api')
            ->json('DELETE', "/api/teams/{$team->id}")
            ->assertStatus(200)->assertJson([
                'status' => true,
                'message' => 'Team Deleted'
            ]);
    }
}
