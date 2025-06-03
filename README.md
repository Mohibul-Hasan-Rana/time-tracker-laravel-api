## Installation
 1. Clone the repository from: ``` git clone https://github.com/Mohibul-Hasan-Rana/time-tracker-laravel-api.git```

 2. Navigate to the project directory: ```cd time-tracker-laravel-api```

 3. Install dependencies: ```composer update```

 4. Set up environment variables: ```cp .env.example .env```

 5. Generate an application key: ```php artisan key:generate```

 6. Update database information in env file. 

 7. Run migration file: ```php artisan migrate```

 8. Run those command ```composer dumpautoload``` and ```php artisan config:cache```

 ## Usage 

 1. Run this command: ```php artisan serve``` 

 2. Paste this URL in browser: http://127.0.0.1:8000/ 

 3. Run ```php artisan queue:work``` for sending mail if user log more than 8 hours.

 ## API Endpoints

### Authentication
```
POST /api/register    - Register new user
POST /api/login       - Login user
POST /api/logout      - Logout user
```

### Clients

```
GET /api/clients - List all clients

POST /api/clients - Create a new client

GET /api/clients/{id} - Get a specific client

PUT /api/clients/{id} - Update a client

DELETE /api/clients/{id} - Delete a client

```

### Projects

```
GET /api/projects - List all projects

POST /api/projects - Create a new project

GET /api/projects/{id} - Get a specific project

PUT /api/projects/{id} - Update a project

DELETE /api/projects/{id} - Delete a project

```

### Time Logs

```
GET /api/time-logs - List all time logs

POST /api/time-logs - Create a manual time log

POST /api/time-logs/start - Start a new time log

PUT /api/time-logs/{id}/stop - Stop an active time log

GET /api/time-logs/{id} - Get a specific time log

PUT /api/time-logs/{id} - Update a time log

DELETE /api/time-logs/{id} - Delete a time log

```

### Reports

```
GET /api/reports - Generate a time log report

You can give type as a parameter. There are two types - daily and client. By default there is default type, need not provide type. 

GET /api/reports?type=daily for daily
GET /api/reports?type=client for client
GET /api/reports 

```

Query parameters: 

```
client_id - Filter by client

project_id - Filter by project

from - Start date (YYYY-MM-DD)

to - End date (YYYY-MM-DD)

tag - Filter by tag name (e.g., billable)

```
