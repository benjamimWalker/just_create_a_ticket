<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket List</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css'])
    @vite(['resources/js/app.js'])
</head>
<body class="bg-gray-100 p-6">
<div class="max-w-4xl mx-auto" x-data="ticketApp()" x-init="fetchTickets(); initEcho();">
    <!-- Create Ticket Modal -->
    <div x-show="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md" @click.away="showModal = false">
            <div class="p-6">
                <h2 class="text-xl font-bold mb-4">Create New Ticket</h2>

                <form @submit.prevent="createTicket">
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                        <input
                            type="text"
                            id="title"
                            x-model="form.title"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md"
                            required
                            maxlength="255">
                        <p x-show="errors.title" x-text="errors.title" class="text-red-500 text-xs mt-1"></p>
                    </div>

                    <div class="mb-4">
                        <label for="priority" class="block text-sm font-medium text-gray-700 mb-1">Priority</label>
                        <input
                            type="number"
                            id="priority"
                            x-model="form.priority"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md"
                            required>
                        <p x-show="errors.priority" x-text="errors.priority" class="text-red-500 text-xs mt-1"></p>
                    </div>

                    <div class="mb-4">
                        <label class="flex items-center">
                            <input
                                type="checkbox"
                                x-model="form.status"
                                class="rounded border-gray-300 text-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Status (Open)</span>
                        </label>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button
                            type="button"
                            @click="showModal = false"
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700">
                            Cancel
                        </button>
                        <button
                            type="submit"
                            class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600"
                            :disabled="isSubmitting">
                            <span x-show="!isSubmitting">Create Ticket</span>
                            <span x-show="isSubmitting">Creating...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Tickets</h1>
        <button
            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded"
            @click="showModal = true">
            Create New Ticket
        </button>
    </div>

    <div class="grid gap-4">
        <template x-for="ticket in tickets" :key="ticket.id">
            <a
                :href="`/tickets/${ticket.id}/replies`"
                class="block bg-white p-4 rounded shadow hover:shadow-md transition-shadow cursor-pointer"
            >
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="font-semibold text-lg" x-text="ticket.title"></h3>
                        <p class="text-gray-600">
                            Priority: <span x-text="ticket.priority"></span>
                        </p>
                    </div>
                    <span
                        class="px-2 py-1 rounded text-xs font-medium"
                        :class="ticket.status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
                        x-text="ticket.status ? 'Open' : 'Closed'">
                    </span>
                </div>
            </a>
        </template>
    </div>

    <div x-show="loading" class="text-center py-4">
        Loading tickets...
    </div>
</div>

<script>
    function ticketApp() {
        return {
            tickets: [],
            loading: true,
            showModal: false,
            isSubmitting: false,
            errors: {},
            form: {
                title: '',
                status: true,
                priority: 1
            },

            initEcho() {
                Echo.channel('tickets')
                    .listen('TicketCreated', (e) => {
                        this.tickets.unshift(e.ticket)
                    })
            },

            fetchTickets() {
                this.loading = true;
                fetch('/api/tickets')
                    .then(response => response.json())
                    .then(data => {
                        this.tickets = data;
                        this.loading = false;
                    })
                    .catch(error => {
                        console.error('Error fetching tickets:', error);
                        this.loading = false;
                    });
            },

            createTicket() {
                this.isSubmitting = true;
                this.errors = {};

                fetch('/api/tickets', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(this.form)
                })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(err => { throw err; });
                        }
                        return response.json();
                    })
                    .then(data => {
                        this.tickets.unshift(data);
                        this.showModal = false;
                        this.resetForm();
                    })
                    .catch(error => {
                        if (error.errors) {
                            this.errors = error.errors;
                        } else {
                            alert('An error occurred while creating the ticket');
                        }
                    })
                    .finally(() => {
                        this.isSubmitting = false;
                    });
            },

            resetForm() {
                this.form = {
                    title: '',
                    status: true,
                    priority: 1
                };
            }
        }
    }
</script>
</body>
</html>
