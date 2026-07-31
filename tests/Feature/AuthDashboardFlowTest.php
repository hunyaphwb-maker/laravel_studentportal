<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AuthDashboardFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_users_are_redirected_to_login_when_opening_the_dashboard(): void
    {
        $this->get('/dashboard')
            ->assertRedirect('/login');
    }

    public function test_a_user_can_register_and_complete_profile_crud_actions(): void
    {
        $this->post('/register', [
            'name' => 'Maria Santos',
            'email' => 'maria@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])->assertRedirect('/dashboard');

        $this->assertDatabaseHas('users', [
            'email' => 'maria@example.com',
        ]);

        $this->post('/profiles', [
            'full_name' => 'Maria Santos',
            'phone' => '+63 912 345 6789',
            'address' => 'Quezon City',
            'birthdate' => '2002-05-15',
            'bio' => 'Computer science student leader.',
        ])->assertRedirect('/dashboard');

        $profileId = DB::table('profiles')->value('id');

        $this->assertDatabaseHas('profiles', [
            'id' => $profileId,
            'full_name' => 'Maria Santos',
        ]);

        $this->put('/profiles/'.$profileId, [
            'full_name' => 'Maria Santos Updated',
            'phone' => '+63 912 000 0000',
            'address' => 'Makati City',
            'birthdate' => '2002-05-15',
            'bio' => 'Updated profile bio.',
        ])->assertRedirect('/dashboard');

        $this->assertDatabaseHas('profiles', [
            'id' => $profileId,
            'full_name' => 'Maria Santos Updated',
            'address' => 'Makati City',
        ]);

        $this->delete('/profiles/'.$profileId)
            ->assertRedirect('/dashboard');

        $this->assertDatabaseMissing('profiles', [
            'id' => $profileId,
        ]);
    }
}
