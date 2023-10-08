# Puisiku: A Personal Library of Poems

Puisiku is a unique digital platform designed for both creators and readers of poetry. Built with PHP, HTML, CSS, and JS, it provides a user-friendly interface where creators can effortlessly publish their poems. Readers, on the other hand, can enjoy a vast collection of poems at their fingertips. The application utilizes a PostgreSQL database for reliable data persistence, ensuring that every piece of poetry is safely stored and readily retrievable. Moreover, Puisiku runs in a Docker container, which simplifies setup and deployment, making it easily accessible across various systems. Experience the joy of poetry like never before with Puisiku - your personal poetry library!

## Prerequisites

To run Puisiku, `Docker` must be installed. If Docker is not yet installed, it can be downloaded from the official Docker website.

## Pre-run Setup

Setting up environment variables is necessary before running the application. An example of these variables is provided in the `.env.example` file. Follow these steps to set up the environment variables:

1. Find the `.env.example` file in the root directory of the project.
2. Copy this file in the same directory.
3. Rename the copied file to `.env`.

After these steps, open the `.env` file and replace the placeholder values with the actual environment variables. Here are the default values:

```bash
PSQL_HOST=puisiku-db
PSQL_PORT=5432
PSQL_NAME=puisiku-db
PSQL_USER=puisiku
PSQL_PASSWORD=puisiku
```

## Running the Program
1. Clone this repository
2. Ensure `Docker Daemon` is running
3. On root directory, run `make run-build` or `docker compose up -d --build` on terminal
4. Access the web application by navigating to `localhost:5001` in the web browser

## User Interface Screenshots
### Landing Page

### Login Page

### Register Page

### Poems Page

### Poem Page

### Playlist Page

### Profile Page

## Lighthouse Analysis
### Landing Page

### Login Page

### Register Page

### Poems Page

### Poem Page

### Playlist Page

### Profile Page

## Task Division
### Server Side

### Client Side