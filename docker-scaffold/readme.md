# Docker Scaffold And Project Start
Starting a project from docker without having any dependencies installed locally. You could use something like this to create an app from scratch and do all code generation from within a container.

This example is interactive and you should follow the steps to see how it works.

## Scaffold
- run `docker-compose -f docker-compose-scaffold up` 
	- Specify the docker-compose file we want to use.
	- This triggers a shell script that saffolds out our express app.

docker-compose-scaffold.yml
```yml
version: '3'
services:  
  scaffold:
    build:
      context: .
      dockerfile: docker/Dockerfile.scaffold
    volumes:
      - ./:/app
      - /app/node_modules
```

Dockerfile.scaffold 
```dockerfile
## Use specific version of node
FROM node:8.7.0

## Get anything we may need for our container and run updates
RUN apt-get update -qq && apt-get install -y build-essential

## Create a directory
RUN mkdir /app

## Set that as our working directory
WORKDIR /app

## Add all of the root files into the container ( Note you can specify things vs bringing everything over )
ADD . /app

## Run npm install for globals
RUN npm install express-generator -g

COPY docker/scaffold.sh /
RUN chmod +x /scaffold.sh
CMD ["/scaffold.sh"]
``` 
This will install global node things as well as call a shell script to scaffold out our exzpress app.

## Running
- run `docker-compose up`
	- This starts the app. You would only need to run the scaffold script once in this case, from here you can check the project in and just use `docker-compose up`

If you wanted to add new dependencies you can do something like this.
- `docker-compose down`
- `docker-compose run npm install nodemon --save`
- Update your package json to use nodemon vs node in the start task. 
- `docker-compose build`
- `docker-compose up`

magic.

