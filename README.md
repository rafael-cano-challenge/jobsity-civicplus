# Challenge Event Management Application
### by José Rafael Cano P. (Senior Software Developer)

A web application built with PHP (server-side) and JavaScript (client-side) to manage events, allowing users to list, add, and view event details.  

My intention developing the challenge was demonstrate clean architecture, best practices, and UI design.

## Features

- 📅 **List Events**: View all events in a list format
- ➕ **Add Events**: Create new events with validation
- 🔍 **Event Details**: View complete event details
- 🔒 **API Security**: Key-based authentication
- 📱 **Web-Friendly**: UI design

## Technologies

| Area          | Technologies Used |
|---------------|-------------------|
| **Backend**   | php:8.2-fpm-alpine (No frameworks) |
| **Frontend**  | JavaScript, Vue.js |
| **Styling**   | Tailwind CSS |
| **Infra**     | Docker, Nginx, PHP-FPM |
| **Testing**   | PHPUnit |

## Run System
**1** cd php-server  
**2** docker-compose up --build -d  

**1** cd frontend  
**2** docker-compose up --build -d  

Back: http://localhost:84/  
Front: http://localhost:5173/

It's all, you can test it. Just you need docker on your machine.

![Texto alternativo](https://raw.githubusercontent.com/rafael-cano-challenge/jobsity-civicplus/main/preview.png)

## Run tests  
**1** docker ps  
**2** docker exec -it [container-id] /bin/sh  
**3** ./vendor/bin/phpunit tests  

## Back Structure (Based on DDD architecture)
![Texto alternativo](https://raw.githubusercontent.com/rafael-cano-challenge/jobsity-civicplus/main/back-scafolding.png)

## Frontend Structure
![Texto alternativo](https://raw.githubusercontent.com/rafael-cano-challenge/jobsity-civicplus/main/frontend-scafolding.png)
