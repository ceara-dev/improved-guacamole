<?php

test('login page is accessible', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
});

test('home page redirects to login when not authenticated', function () {
    $this->get('/profile')->assertRedirect('/login');
});
