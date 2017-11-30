# Docker Intro
Let's go over a simple Dockerfile as well as Docker Compose.

## Dockerfile
You will see in `docker/Dockerfile` a file that describes our container. In this example we are using Node v8.7.0.

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

## Run npm install
RUN npm install
```

What you see here is describing our container. Let's go over a couple things quickly.

`FROM node:8.7.0` is pulling from the official Node Docker repo ( https://hub.docker.com/_/node/ )

Sometimes you might not need to do anything beyond this, but the beauty of creating your own Dockerfile is that you can take extra actions on the container such as what we are doing here.

We are running `npm install` for this example though we have no dependencies. On my system I have nvm installed so I can scaffold this project, but if you were picking this up in theory you wouldn't need it.

## Files
- `package.json` - Normal package.json
- `index.json` - Logs out a message
- `docker-compose.yml` - Describes our docker containers

## Commands
Docker has a few essential commands to know, these will help you as you move through these projects.

### Basics
- `docker-compose ps` - Lists any running containers and their current status / port 
- `docker-compose up` - Starts docker 
- `docker-compose down` - Stops all running containers
- `docker-compose rm` - Removes containers
- `docker-compose down -v` - Stops containers and removes any linked volumes ( this may be good when you want to wipe a database or any linked volumes )
- `docker images` - Lists all docker images
- `docker --help` - Check out the other commands

### Kill it with fire
- `docker rm $(docker ps -a -q)` - Kills all containers
- `docker rmi $(docker images -q)` - will toast ALL of your images

## Docker-Compose
Docker compose is how we can connect all of our containers and allow them to work together.

```yml
version: '2'
services:  
  builder:
    build:
      context: .
      dockerfile: docker/Dockerfile
    volumes:
      - ./:/app
    command: /bin/bash -c "npm start"
```

So WTF is this?
- `version` - the version of docker
- `services` - our containers
	- `builder` - A container named builder ( this could be anything really )
		- `build` - What to build
			- `context` - The context in which docker is running
			- `dockerfile` - Point to our dockerfile.
		- `volumes` - Here we map where data is coming from and dependencies for our app.
			- `./:/app` - Looking at the Dockerfile you see that we are adding all local files to the container, and putting them in an `app` directory and making that our working directory. This means that everything in the directory is now in the container but this volume means that everything local stays in sync with our container.
		- `commands` - If you want to run a specific command on a container after it's been created and booted, here we are just running `npm start` which is defined in our Dockerfile.

## Run it
Okay cool so that's the basicis, but how do we run this?
- run `docker-compose up`

When this is run Docker will initialize `docker-compose.yml` file and start building the services we've defined there.

You should see the following: ( this is after docker has installed any required images )

```dockerfile
Creating network "intro_default" with the default driver
Building builder
Step 1/7 : FROM node:8.7.0
 ---> badd967af535
Step 2/7 : RUN apt-get update -qq && apt-get install -y build-essential
 ---> Using cache
 ---> 2cc0eac74f99
Step 3/7 : RUN mkdir /app
 ---> Using cache
 ---> 69068119a06f
Step 4/7 : WORKDIR /app
 ---> Using cache
 ---> 9c1d9208aa9a
Step 5/7 : ADD . /app
 ---> 962f3827d9b0
Step 6/7 : RUN npm install
 ---> Running in fcab06549771
npm info it worked if it ends with ok
npm info using npm@5.4.2
npm info using node@v8.7.0
npm info lifecycle dockerize-all-the-things-intro@1.0.0~preinstall: dockerize-all-the-things-intro@1.0.0
npm info linkStuff dockerize-all-the-things-intro@1.0.0
npm info lifecycle dockerize-all-the-things-intro@1.0.0~install: dockerize-all-the-things-intro@1.0.0
npm info lifecycle dockerize-all-the-things-intro@1.0.0~postinstall: dockerize-all-the-things-intro@1.0.0
npm info lifecycle dockerize-all-the-things-intro@1.0.0~prepublish: dockerize-all-the-things-intro@1.0.0
npm info lifecycle dockerize-all-the-things-intro@1.0.0~prepare: dockerize-all-the-things-intro@1.0.0
npm info lifecycle undefined~preshrinkwrap: undefined
npm info lifecycle undefined~shrinkwrap: undefined
npm notice created a lockfile as package-lock.json. You should commit this file.
npm info lifecycle undefined~postshrinkwrap: undefined
npm WARN dockerize-all-the-things-intro@1.0.0 No repository field.

up to date in 0.097s
npm info ok
 ---> 77e916fd2eef
Removing intermediate container fcab06549771
Step 7/7 : EXPOSE 8080
 ---> Running in 73bba22eb133
 ---> c3382f723590
Removing intermediate container 73bba22eb133
Successfully built c3382f723590
Successfully tagged intro_builder:latest
WARNING: Image for service builder was built because it did not already exist. To rebuild this image you must use `docker-compose build` or `docker-compose up --build`.
Creating intro_builder_1 ...
Creating intro_builder_1 ... done
Attaching to intro_builder_1
builder_1  | npm info it worked if it ends with ok
builder_1  | npm info using npm@5.4.2
builder_1  | npm info using node@v8.7.0
builder_1  | npm info lifecycle dockerize-all-the-things-intro@1.0.0~prestart: dockerize-all-the-things-intro@1.0.0
builder_1  | npm info lifecycle dockerize-all-the-things-intro@1.0.0~start: dockerize-all-the-things-intro@1.0.0
builder_1  |
builder_1  | > dockerize-all-the-things-intro@1.0.0 start /app
builder_1  | > node index.js
builder_1  |
builder_1  | #####################################
builder_1  | hello from the container!
builder_1  | #####################################
builder_1  | npm info lifecycle dockerize-all-the-things-intro@1.0.0~poststart: dockerize-all-the-things-intro@1.0.0
builder_1  | npm info ok
intro_builder_1 exited with code 0
```
Neat! See our log? How rad is that? That log is coming from our container. What's really neat about docker is now that you've run this you have created the container so your next run will be much faster.

