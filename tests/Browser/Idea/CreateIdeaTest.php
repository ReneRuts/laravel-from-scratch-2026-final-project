<?php

use App\Models\Idea;
use App\Models\User;

it('creates a new idea', function () {
    $this->actingAs($user = User::factory()->create());
    visit('/ideas')
        ->click('@create-idea-button')
        ->fill('title', 'Some example title')
        ->click('@button-status-completed')
        ->fill('description', 'an example description')
        ->fill('@new-link', 'https://airmanballooning.be')
        ->click('@submit-new-link-button')
        ->fill('@new-link', 'https://hairshopper.be')
        ->click('@submit-new-link-button')
        ->fill('@new-step', 'Do a thing')
        ->click('@submit-new-step-button')
        ->fill('@new-step', 'Do another thing')
        ->click('@submit-new-step-button')
        ->click('Create')
        ->assertPathIs('/ideas');

    expect($idea = $user->ideas()->first())->toMatchArray([
        'title' => 'Some example title',
        'status' => 'completed',
        'description' => 'an example description',
        'links' => ['https://airmanballooning.be', 'https://hairshopper.be'],
    ]);

    expect($idea->steps)->toHaveCount(2);
});