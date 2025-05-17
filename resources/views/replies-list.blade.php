<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Replies</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css'])
    @vite(['resources/js/app.js'])
</head>
<body class="bg-gray-100 p-6">
<div class="max-w-4xl mx-auto" x-data="repliesApp()" x-init="fetchReplies()">
    <!-- Header with back button and ticket status toggle -->
    <div class="flex justify-between items-center mb-6">
        <a href="/tickets" class="text-blue-500 hover:text-blue-700 flex items-center">
            ← Back to tickets
        </a>
        <button
            @click="toggleStatus"
            class="px-4 py-2 rounded font-medium"
            :class="ticket.status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
            x-text="ticket.status ? 'Open' : 'Closed'">
        </button>
    </div>

    <h1 class="text-2xl font-bold text-gray-800 mb-4" x-text="ticket.title"></h1>

    <!-- Replies list -->
    <div class="bg-white rounded shadow mb-6">
        <template x-for="reply in replies" :key="reply.id">
            <div class="p-4 border-b border-gray-200">
                <p x-text="reply.message" class="text-gray-800"></p>
                <p class="text-xs text-gray-500 mt-1" x-text="formatDate(reply.created_at)"></p>
            </div>
        </template>
    </div>

    <!-- New reply form - only show if ticket is open -->
    <div x-show="ticket.status" class="bg-white p-4 rounded shadow">
        <form @submit.prevent="addReply" class="flex items-center gap-4"> <!-- Added gap-4 for spacing -->
            <input
                type="text"
                x-model="newReply"
                placeholder="Type your reply..."
                class="flex-1 px-3 py-2 border border-gray-300 rounded-md"
                required>
            <button
                type="submit"
                class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                Send
            </button>
        </form>
    </div>

    <!-- Message when ticket is closed -->
    <div x-show="!ticket.status" class="bg-white p-4 rounded shadow text-center text-gray-500">
        This ticket is closed. No new replies can be added.
    </div>
</div>

<script>
    function repliesApp() {
        return {
            ticket: {
                id: {{ $ticket->id }},
                title: "{{ $ticket->title }}",
                status: {{ $ticket->status ? 'true' : 'false' }}
            },
            replies: [],
            newReply: '',
            loading: false,

            fetchReplies() {
                this.loading = true;
                fetch(`/api/tickets/${this.ticket.id}/replies`)
                    .then(response => response.json())
                    .then(data => {
                        this.replies = data;
                        this.loading = false;
                    });
            },

            addReply() {
                if (!this.ticket.status) return;

                fetch(`/api/tickets/${this.ticket.id}/replies`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        message: this.newReply,
                        ticket_id: this.ticket.id // Added ticket_id to the request
                    })
                })
                    .then(response => {
                        if (response.ok) {
                            this.newReply = ''; // Just clear the input
                            // Don't update the UI - we'll add websockets later
                        }
                    });
            },

            toggleStatus() {
                fetch(`/api/tickets/${this.ticket.id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ status: !this.ticket.status ? 1 : 0 })
                })
                // Don't update the UI - we'll add websockets later
            },

            formatDate(dateString) {
                return new Date(dateString).toLocaleString();
            }
        }
    }
</script>
</body>
</html>
