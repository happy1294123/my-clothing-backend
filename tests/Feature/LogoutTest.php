<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_成功登出_刪除該用戶所有accessToken()
    {
        $user = User::factory()->create(['password' => '12345678']);
        $this->postJson(route('user.login'), [
            'email' => $user->email,
            'password' => '12345678'
        ]);

        $this->actingAs($user, 'sanctum')
                ->getJson(route('user.logout'))
                ->assertStatus(204);

        $this->assertDatabaseEmpty('personal_access_tokens');
    }
}
