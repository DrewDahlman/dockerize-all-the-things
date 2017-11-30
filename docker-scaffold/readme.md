# Docker Scaffold And Project Start
Starting a project from docker without having any dependencies installed locally. You could use something like this to create an app from scratch and do all code generation from within a container.

This example is interactive and you should follow the steps to see how it works.

## Run
- `docker-compose up`
	- This will start a running container.

Our Dockerfile in this case is globally installing `express-generator`.

```bash
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

## Install anything from our package
RUN npm install

ENTRYPOINT ["tail", "-f", "/dev/null"]
```

## Scaffold our app
- In a new window 
	- `docker-compose exec builder bash`
		- full `docker-compose exec <service> bash`
		- This will put you into your container.
	- `express .`
		- Fill in the information it asks you for.
	- `npm install`
	- `node start`
	- visit http://localhost:3000

Now you can edit your code in your IDE and it will be synced up with your container.

## Post scaffold
After you do the initial scaffold of the app you can comment out the `ENTRYPOINT` from the dockerfile and then add the command in `docker-compose.yml`

Make sure to run `docker-compose down` and then make your changes, then run `docker-compose build` after making these changes in order for your container to know there are changes. From that point you should good to go.

```yml
version: '2'
services:  
  builder:
    build:
      context: .
      dockerfile: docker/Dockerfile
    ports:
      - 3000:3000
    volumes:
      - ./:/app
      - /app/node_modules
    command: /bin/bash -c "npm start"
```

From that point on you can just run `docker-compose up` and the app will start right up.

