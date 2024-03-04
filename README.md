<h1 align="center">
  Microservice implementing Hexagonal Architecture, DDD & CQRS
</h1>



<p align="center">
  This entails the development of two microservices – User and Notification – 
implemented using a blend of Laravel and Symfony PHP frameworks. The architecture follows 
the principles of Domain-Driven Design (DDD) and Command Query Responsibility Segregation (CQRS), 
ensuring scalability, maintainability, and flexibility.
  <br />
  <br />
</p>

## Installation

### Requirements
- [Install Docker](https://www.docker.com/get-started)
- [Install Docker Compose](https://docs.docker.com/compose/install/)

### Environment

- Clone this project: `git clone https://github.com/enochval/next-basket-challenge.git`
- Move to the project folder: `cd next-basket-challenge`

### Execution

Install all the dependencies and bring up the project with Docker executing:

`make build`\
`make up`\
`make migrate`

Then you'll have 2 apps available (an API) and a notification service (a Consumer):

-  API: http://localhost:8080/api/users

### API Documentation

Postman API collection [here](https://documenter.getpostman.com/view/1434697/2sA2xcaueA)

### Tests

Execute all test suites: `make tests`

### Stop Containers

Execute `make destory` to stop all running containers.

### RabbitMQ

There is a service with RabbitMQ to manage queues. You can access it going to ` http://localhost:15672` and using `guest` as username and password.
The consumed message is stored in a file called `consumer-log.json`in the `notification-service`

### Admirer

There is a service to with Admirer to manage the database. You can access it going to ` http://localhost:8081` and using `root` as username and `secret` password.
