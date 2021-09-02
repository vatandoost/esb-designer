<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use WithFaker;
    public function test_protection()
    {
        $response = $this->get(route('user.index'));
        $response->assertRedirect('/login');

        /** @var Authenticatable */
        $user = User::factory()->create(['is_admin' => false]);

        $response = $this->actingAs($user)->get(route('user.index'));
        $response->assertForbidden();
    }

    public function test_create_user()
    {
        /** @var User */
        $user = User::factory()->create(['is_admin' => true]);
        $name = $this->faker->firstName();
        $email = $this->faker->email();
        $response = $this->actingAs($user)->post(route('user.store'), [
            'name' => $name,
            'email' => $email,
            'is_admin' => true,
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);
        $item = User::firstWhere('email', $email);
        $this->assertTrue($item->exists);
        $response->assertRedirect(route('user.index'));
    }

    public function test_create_user_validations()
    {
        /** @var User */
        $user = User::factory()->create(['is_admin' => true]);
        $this->be($user);

        $name = $this->faker->firstName();
        $email = $this->faker->email();

        //short password
        $response = $this->post(route('user.store'), [
            'name' => $name,
            'email' => $email,
            'is_admin' => true,
            'password' => 'pass',
            'password_confirmation' => 'pass',
        ]);
        $response->assertSessionHasErrors(['password']);
        $item = User::firstWhere('email', $email);
        $this->assertEmpty($item);

        //wrong email
        $response = $this->post(route('user.store'), [
            'name' => $name,
            'email' => 'email.com',
            'is_admin' => true,
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);
        $item = User::firstWhere('email', 'email.com');
        $this->assertEmpty($item);

        //duplicate email
        $user2 = User::factory()->create();
        $response = $this->post(route('user.store'), [
            'name' => $name,
            'email' => $user2->email,
            'is_admin' => true,
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);
        $response->assertSessionHasErrors(['email']);
        $item = User::firstWhere('email', $user2->email);
        $this->assertFalse($item->name == $name);
    }


    public function test_update_user()
    {
        /** @var User */
        $user = User::factory()->create(['is_admin' => true]);

        $user2 = User::factory()->create();

        $name = $this->faker->firstName();
        $email = $this->faker->email();
        $response = $this->actingAs($user)->post(route('user.update', ['user' => $user2->id]), [
            'name' => $name,
            'email' => $email,
            'is_admin' => false,
            'password' => '',
            'password_confirmation' => '',
        ]);
        $user2->refresh();
        $this->assertTrue($user2->name == $name);
        $this->assertTrue($user2->email == $email);
        $response->assertRedirect(route('user.index'));
        $response->assertSessionHas('toast_message');

        //test password change
        $response = $this->actingAs($user)->post(route('user.update', ['user' => $user2->id]), [
            'name' => $name,
            'email' => $email,
            'is_admin' => false,
            'password' => 'pass123456',
            'password_confirmation' => 'pass123456',
        ]);
        $user2->refresh();
        $response->assertRedirect(route('user.index'));
        $response->assertSessionHas('toast_message');

        $res = $this->post('/login', [
            'email' => $email,
            'password' => 'pass123456',
        ]);

        $res->assertRedirect();
        $this->assertAuthenticated();

    }

    public function test_delete_user()
    {
        /** @var User */
        $user = User::factory()->create(['is_admin' => true]);
        $this->be($user);

        $item = User::factory()->create();
        $response = $this->delete(route('user.delete', ['user' => $item->id]));

        $response->assertRedirect(route('user.index'));
        $response->assertSessionHas('toast_message');
        $this->assertEmpty(User::find($item->id));
    }

    /**
     * user must not be able to delete itself
     */
    public function test_delete_itself()
    {
        /** @var User */
        $user = User::factory()->create(['is_admin' => true]);
        $this->be($user);

        $response = $this->delete(route('user.delete', ['user' => $user->id]));

        $this->assertNotEmpty(User::find($user->id));
        $response->assertForbidden();
    }
}
