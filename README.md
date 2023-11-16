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

REST_BASE_URL=http://puisiku-rest-service:3000
REST_PUBLIC_BASE_URL=http://localhost:3000

SOAP_BASE_URL=http://puisiku-soap-service:8888

REST_API_KEY=restnibos
SOAP_API_KEY=fromphp
```

## Running the Program
1. Clone this repository
2. Ensure `Docker Daemon` is running
3. On root directory, run `make run-build` or `docker compose up -d --build` on terminal
4. Access the web application by navigating to `localhost:5001` in the web browser
5. Run `docker compose down` to stop the app.

## User Interface Screenshots
### Landing Page
![image](https://github.com/JeffreyChow19/IF3110-2023-01-15-Milestone-1/assets/landing.png)

### Login Page
![image](https://github.com/JeffreyChow19/IF3110-2023-01-15-Milestone-1/assets/login.png)

### Register Page
![image](https://github.com/JeffreyChow19/IF3110-2023-01-15-Milestone-1/assets/register.png)

### Poems Page
![image](https://github.com/JeffreyChow19/IF3110-2023-01-15-Milestone-1/assets/poems.png)

### Poem Page
![image](https://github.com/JeffreyChow19/IF3110-2023-01-15-Milestone-1/assets/poem.png)

### Playlist Page
![image](https://github.com/JeffreyChow19/IF3110-2023-01-15-Milestone-1/assets/playlist.png)

### Profile Page
![image](https://github.com/JeffreyChow19/IF3110-2023-01-15-Milestone-1/assets/profile.png)

### Error Page
![image](https://github.com/JeffreyChow19/IF3110-2023-01-15-Milestone-1/assets/error.png)

### Admin Page
![image](https://github.com/JeffreyChow19/IF3110-2023-01-15-Milestone-1/assets/admin.png)

### Creator Page
![image](https://github.com/JeffreyChow19/IF3110-2023-01-15-Milestone-1/assets/creator.png)

## Lighthouse Analysis
### Landing Page
![image](https://github.com/JeffreyChow19/IF3110-2023-01-15-Milestone-1/assets/landingpage.png)

### Login Page
![image](https://github.com/JeffreyChow19/IF3110-2023-01-15-Milestone-1/assets/loginpage.png)

### Register Page
![image](https://github.com/JeffreyChow19/IF3110-2023-01-15-Milestone-1/assets/registerpage.png)

### Poems Page
![image](https://github.com/JeffreyChow19/IF3110-2023-01-15-Milestone-1/assets/poemspage.png)

### Poem Page
![image](https://github.com/JeffreyChow19/IF3110-2023-01-15-Milestone-1/assets/poempage.png)

### Playlist Page
![image](https://github.com/JeffreyChow19/IF3110-2023-01-15-Milestone-1/assets/playlistpage.png)

### Profile Page
![image](https://github.com/JeffreyChow19/IF3110-2023-01-15-Milestone-1/assets/profilepage.png)

### Error Page
![image](https://github.com/JeffreyChow19/IF3110-2023-01-15-Milestone-1/assets/errorpage.png)

### Admin Page
![image](https://github.com/JeffreyChow19/IF3110-2023-01-15-Milestone-1/assets/adminpage.png)

### Creator Page
![image](https://github.com/JeffreyChow19/IF3110-2023-01-15-Milestone-1/assets/creatorpage.png)

## Task Division
### Server Side
| 10023334                       | 13521046                                                 | 13521103                                          |
|--------------------------------|----------------------------------------------------------|---------------------------------------------------|
| Profile Controller (Load View) | Project structure and architecture (docker and database) | Admin Controller and related service and model    |
| Get Data service               | App and Router                                           | creator controller and related service and model  |
| User find by id model          | Middleware                                               |                                                   |
| Database seeding               | Login controller and related service and model           |                                                   |
|                                | Register controller and related service and model        |                                                   |
|                                | Landing controller and related service and model         |                                                   |
|                                | File controller and service                              |                                                   |
|                                | Errors controller                                        |                                                   |
|                                | Landing controller                                       |                                                   |
|                                | Logout controller and service                            |                                                   |
|                                | Poems controller and related service and model           |                                                   |
|                                | Poem controller and related service and model            |                                                   |
|                                | Profile controller and related service and model         |                                                   |
|                                | Playlist controller and related service and model        |                                                   |
|                                | Playlist Item controller and related service and model   |                                                   |


### Client Side
| Feature           | PIC                 |
|-------------------|---------------------|
| Landing           | 10023334            |
| Login             | 13521046, 13521103  |
| Register          | 13521046, 13521103  |
| Poems             | 13521046            |
| Poem              | 13521046            |
| Playlist          | 13521046            |
| Profile           | 10023334, 13521046  |
| Error             | 10023334            |
| Navbar            | 13521046            |
| Sidebar           | 13521046            |
| Search and Filter | 13521046            |
| Creator           | 13521103            |
| Admin             | 13521103            |
| Layout            | 13521046            |


## Author
| NIM      | Nama                    |
|----------|-------------------------|
| 10023334 | Tubagus Rahardi         |
| 13521046 | Jeffrey Chow            |
| 13521103 | Aulia Mey Diva Annandya |

