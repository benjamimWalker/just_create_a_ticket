<p align="center">
  <img src="https://raw.githubusercontent.com/benjamimWalker/just_create_a_ticket/master/assets/logo.png" alt="Project logo" />
</p>
<p align="center">
  <a href="https://github.com/benjamimWalker/just_create_a_ticket/actions/workflows/tests.yml">
    <img src="https://github.com/benjamimWalker/just_create_a_ticket/actions/workflows/tests.yml/badge.svg" alt="Tests" />
  </a>
</p>

## Overview

JCAT is a real-time ticketing system built with Laravel. It focuses on simplicity and instant communication —create a ticket, reply in threads, and get live updates with no page refresh. It’s built for speed, collaboration, and ease of use.

## Technology

Key Technologies used:

* Laravel 12
* MySQL
* Redis
* Nginx
* Laravel Reverb & Echo (WebSockets)
* Docker + Docker Compose
* Alpine.js & Tailwind CSS
* PestPHP

## Getting started

> [!IMPORTANT]  
> You must have Docker and Docker Compose installed on your machine.

* Clone the repository:
```sh
git clone https://github.com/benjamimWalker/just_create_a_ticket.git
```

* Go to the project folder:
```sh
cd just_create_a_ticket
```

* Prepare environment files:
```sh
cp .env.example .env
```

* Build the containers:
```sh
docker compose up -d
```

* Install composer dependencies:
```sh
docker compose exec app composer install
```

* Run the migrations:
```sh
docker compose exec app php artisan migrate
```

* Install npm dependencies:
```sh
docker compose run --rm npm install
```

* Build the assets:
```sh
docker compose run --rm npm run build
```

* You can now execute the tests:
```sh
docker compose exec app php artisan test
```

* And finally, start reverb websocket server:
```sh
docker compose exec app php artisan reverb:start
```

## How to use

### 1 - Check tickets
Head to the URL `http://localhost/tickets`

![image](https://raw.githubusercontent.com/benjamimWalker/just_create_a_ticket/master/assets/tickets-list.png)

### 3 - Create a ticket
Click the "Create New Ticket" button and fill in the form. You can set a title, priority and status (default for open but you can create a closed for whatever reason)

![image](https://raw.githubusercontent.com/benjamimWalker/just_create_a_ticket/master/assets/ticket-create.png)

### 4 - Check and create a reply
Click on any ticket. You can see the ticket details and all replies. You can also create a new reply.

![image](https://raw.githubusercontent.com/benjamimWalker/just_create_a_ticket/master/assets/replies.png)

## Features

The main features of the application are:
- Real-time ticket threads with WebSocket-powered messaging
- Responsive, lightweight UI with Tailwind and Alpine
- Instant updates to connected users only (per-thread broadcasting)
- Status toggling (open/closed) with locked replies on closed tickets
- Automated tests with Pest. critical paths: creation, validation, messaging

[Benjamim] - [benjamim.sousamelo@gmail.com]<br>
Github: <a href="https://github.com/benjamimWalker">@benjamimWalker</a>
