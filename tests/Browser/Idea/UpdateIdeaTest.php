<?php

use App\Models\Idea;
use App\Models\User;

it('shows the initial input state', function () {
    $this->actingAs($user = User::factory()->create());

    $idea = Idea::factory()->for($user)->create();

    visit(route('idea.show', $idea))
        ->click('@edit-idea-button')
        ->assertValue('title', $idea->title)
        ->assertValue('description', $idea->description)
        ->assertValue('status', value: $idea->status->value);
});

it('edits an existing idea', function () {
    $this->actingAs($user = User::factory()->create());

    $idea = Idea::factory()->for($user)->create();
    $originalLink = $idea->links[0] ?? null;

    visit(route('idea.show', $idea))
        ->click('@edit-idea-button')
        ->fill('title', 'Some example title')
        ->click('@button-status-completed')
        ->fill('description', 'an example description')
        ->fill('@new-link', 'https://airmanballooning.be')
        ->click('@submit-new-link-button')
        ->fill('@new-step', 'Do a thing')
        ->click('@submit-new-step-button')
        ->click('@button-update')
        ->assertRoute('idea.show', [$idea]);

    expect($idea = $user->ideas()->first())->toMatchArray([
        'title' => 'Some example title',
        'status' => 'completed',
        'description' => 'an example description',
        'links' => $originalLink ? [$originalLink, 'https://airmanballooning.be'] : ['https://airmanballooning.be'],
    ]);

    expect($idea->steps)->toHaveCount(1);
});
