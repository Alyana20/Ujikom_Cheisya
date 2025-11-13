<?php

use App\Models\User;

it('can register then login with different-case and surrounding spaces in email', function () {
    // Register with mixed-case email
    $response = $this->post('/register', [
        'name' => 'Case Test',
        'email' => 'User@Example.COM',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));

    // Logout
    $this->post('/logout');
    $this->assertGuest();

    // Attempt login with trimmed/lowercase email and surrounding spaces
    $login = $this->post('/login', [
        'email' => '  user@example.com  ',
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
});
