<?php

use App\Models\Ticket;

beforeEach(function () {
    Ticket::unsetEventDispatcher();
});

test('updates ticket status', function () {
    $ticket = Ticket::factory()->create(['status' => true]);

    $this->putJson("api/tickets/$ticket->id", [
        'status' => false
    ])
        ->assertOk();

    $this->assertDatabaseHas('tickets', [
        'id' => $ticket->id,
        'status' => false
    ]);
});

test('requires status field', function () {
    $ticket = Ticket::factory()->create();

    $this->putJson("api/tickets/$ticket->id")
        ->assertUnprocessable()
        ->assertJsonValidationErrors('status');
});

test('status must be boolean', function () {
    $ticket = Ticket::factory()->create();

    $this->putJson("api/tickets/$ticket->id", [
        'status' => 'not-a-boolean'
    ])
        ->assertUnprocessable()
        ->assertJsonValidationErrors('status');
});

test('returns 404 for non-existent ticket', function () {
   $this->putJson("api/tickets/999", [
        'status' => true
    ])->assertNotFound();
});

test('can toggle status multiple times', function () {
    $ticket = Ticket::factory()->create(['status' => true]);

    $this->putJson("api/tickets/$ticket->id", ['status' => false]);
    $this->assertFalse($ticket->fresh()->status);

    $this->putJson("api/tickets/$ticket->id", ['status' => true]);
    $this->assertTrue($ticket->fresh()->status);
});

test('only updates status field', function () {
    $ticket = Ticket::factory()->create([
        'title' => 'Original Title',
        'status' => true
    ]);

    $this->putJson("api/tickets/$ticket->id", [
        'status' => false,
        'title' => 'Attempted Change'
    ])
        ->assertOk();

    $this->assertDatabaseHas('tickets', [
        'id' => $ticket->id,
        'status' => false,
        'title' => 'Original Title'
    ]);
});
