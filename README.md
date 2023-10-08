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
![image](https://github.com/JeffreyChow19/IF3110-2023-01-15-Milestone-1/assets/88904787/e3bc2505-b818-40ea-967e-cf0e8478395c)

### Login Page
![image](https://github.com/JeffreyChow19/IF3110-2023-01-15-Milestone-1/assets/88904787/e7fb1912-d193-4ab9-b4c9-7e69d3e96c2f)

### Register Page
![image](https://github.com/JeffreyChow19/IF3110-2023-01-15-Milestone-1/assets/88904787/3fd6c290-c7eb-45e8-990e-fae384b16538)

### Poems Page
![image](https://github.com/JeffreyChow19/IF3110-2023-01-15-Milestone-1/assets/88904787/03d350e9-f19b-490e-bd6d-7c06d5217c6c)

### Poem Page
![image](https://github.com/JeffreyChow19/IF3110-2023-01-15-Milestone-1/assets/88904787/2b032c44-b7f2-45a0-b437-c1afc48b5a89)

### Playlist Page
![image](https://github.com/JeffreyChow19/IF3110-2023-01-15-Milestone-1/assets/88904787/8c6ad702-5652-4902-ae36-8048ba6a795b)

### Profile Page
![image](https://github.com/JeffreyChow19/IF3110-2023-01-15-Milestone-1/assets/88904787/49ea9050-11f1-4f72-a577-832d6932739e)

### Error Page
![image](https://github.com/JeffreyChow19/IF3110-2023-01-15-Milestone-1/assets/88904787/bc840d08-4394-4301-9e67-84bf5dac25e3)

## Lighthouse Analysis
### Landing Page
![image](https://github.com/JeffreyChow19/IF3110-2023-01-15-Milestone-1/assets/88904787/69ed9c6b-a4fd-4af3-90b0-ba229c061f97)

### Login Page
![image](https://github.com/JeffreyChow19/IF3110-2023-01-15-Milestone-1/assets/88904787/b0b74d5d-b63f-45fb-965c-8f82ff1e959d)

### Register Page
![image](https://github.com/JeffreyChow19/IF3110-2023-01-15-Milestone-1/assets/88904787/812d5af2-803f-41a4-8bde-bf36c9a976c6)

### Poems Page
![image](https://github.com/JeffreyChow19/IF3110-2023-01-15-Milestone-1/assets/88904787/111142b1-fe18-4c69-9e00-96b525eea2f1)

### Poem Page
![image](https://github.com/JeffreyChow19/IF3110-2023-01-15-Milestone-1/assets/88904787/232f91c3-ba0a-4576-a1c3-78c2de94247a)

### Playlist Page
![image](https://github.com/JeffreyChow19/IF3110-2023-01-15-Milestone-1/assets/88904787/a604448b-8671-4701-9407-0444b91e4a78)

### Profile Page
![image](https://github.com/JeffreyChow19/IF3110-2023-01-15-Milestone-1/assets/88904787/fddef367-3da8-4535-b741-2d70f50084d6)

### Error Page
![image](https://github.com/JeffreyChow19/IF3110-2023-01-15-Milestone-1/assets/88904787/743dfc16-4bbf-43cb-a3e3-d6591477b865)

### Admin Page
![image](https://github.com/JeffreyChow19/IF3110-2023-01-15-Milestone-1/assets/89340189/4e3d3e4c-ecca-4c3b-9c73-f0e068753880)

### Creator Page
![image](https://github.com/JeffreyChow19/IF3110-2023-01-15-Milestone-1/assets/89340189/818868fe-1847-48e0-951e-00f646bd1e0f)

### Admin Page
![image](https://github.com/JeffreyChow19/IF3110-2023-01-15-Milestone-1/assets/89340189/0dddeabc-d25d-4cc0-812b-a088720de8e1)

### Creator Page
![image](https://github.com/JeffreyChow19/IF3110-2023-01-15-Milestone-1/assets/89340189/a046e199-c160-4f17-91d5-56551c55919f)


## Task Division
### Server Side

### Client Side
