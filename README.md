# Puisiku: A Personal Library of Poems

Puisiku is a monolithic application built with PHP, HTML, CSS, and JS. It serves as a personal library for storing and retrieving poems. The application uses a PostgreSQL database for data persistence and runs in a Docker container for easy setup and deployment.

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
