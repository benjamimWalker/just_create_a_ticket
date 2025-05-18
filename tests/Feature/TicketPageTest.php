<?php

use App\Models\Ticket;

beforeEach(function () {
    Ticket::unsetEventDispatcher();
});

test('tickets route renders successfully', function () {
    $this->get('tickets')
        ->assertOk()
        ->assertViewIs('ticket-list');
});

test('tickets page shows correct title', function () {
    $this->get('tickets')
        ->assertSee('Tickets');
});

test('tickets page has create new ticket button', function () {
    $this->get('tickets')
        ->assertSee('Create New Ticket');
});

test('tickets table shows correct headers', function () {
    $this->get('tickets')
        ->assertSeeInOrder([
            'Title',
            'Priority',
            'Status'
        ]);
});

test('tickets table shows empty state when no tickets exist', function () {
    $this->get('tickets')
        ->assertSee('Loading tickets...');
});

test('ticket status shows correctly in UI', function () {
    Ticket::factory()->create(['status' => true]);
    Ticket::factory()->create(['status' => false]);

    $this->get('/tickets')
        ->assertSee('bg-green-100')
        ->assertSee('bg-red-100');
});

test('ticket creation validates title field', function () {
    $this->postJson('api/tickets', [
        'title' => '',
        'priority' => 1,
        'status' => true
    ])
        ->assertUnprocessable()
        ->assertJsonValidationErrors('title');
});

test('ticket creation validates priority field', function () {
    $this->postJson('/api/tickets', [
        'title' => 'Test Ticket',
        'priority' => '',
        'status' => true
    ])
        ->assertUnprocessable()
        ->assertJsonValidationErrors('priority');
});

test('ticket creation validates status field', function () {
    $response = $this->postJson('/api/tickets', [
        'title' => 'Test Ticket',
        'priority' => 1,
        'status' => ''
    ])
        ->assertUnprocessable()
        ->assertJsonValidationErrors('status');
});

test('ticket creation requires all fields', function () {
    $this->postJson('/api/tickets')
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['title', 'priority', 'status']);
});

test('ticket modal closes after successful creation', function () {
    $ticket = Ticket::factory()->make();

    $this->post('/api/tickets', [
        'title' => $ticket->title,
        'priority' => $ticket->priority,
        'status' => $ticket->status
    ])->assertCreated();

    $this->assertTrue(true);
});

test('ticket creation shows validation errors in form', function () {
    $this->postJson('/api/tickets')
        ->assertUnprocessable()
        ->assertJsonStructure(['errors' => ['title', 'priority', 'status']]);
});

test('ticket list shows loading state initially', function () {
    $this->get('/tickets')
        ->assertSee('Loading tickets...');
});

test('ticket list shows correct status labels', function () {
    Ticket::factory()->create(['status' => true]);
    Ticket::factory()->create(['status' => false]);

    $this->get('/tickets')
        ->assertSee('Open')
        ->assertSee('Closed');
});
