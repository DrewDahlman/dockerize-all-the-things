# Express App
A sample of an express app running in a container.

## Getting Started
As noted in the intro you will still install some generators for scaffolding apps. For this I have `npm install express-generator -g` and generated a basic app.

## Running
run `docker-compose up`
visit http://localhost:3000/

Boom we have an express app that is now running in a container! Let's look at what has changed from our initial setup.

In our `docker-compose.yml`
```yml
version: '2'
services:  
  builder:
    build:
      context: .
      dockerfile: docker/Dockerfile
    ports:
      - 3000:3000 # Added a port
    volumes:
      - ./:/app
      - /app/node_modules
    command: /bin/bash -c "npm start"
```

Let's break this down again. The only thing we've added is the `ports` in our builder service. This allows us to map our local machine to our containers port. 
- `version` - the version of docker
- `services` - our containers
	- `builder` - A container named builder ( this could be anything really )
		- `build` - What to build
			- `context` - The context in which docker is running
			- `dockerfile` - Point to our dockerfile.
		- `ports` - Ports to expose ( see the Dockerfile ) you can map these to your local machine. If we wanted to run our app on port `80` on our machine but 8080 on the container it could be `80:8080`
		- `volumes` - Here we map where data is coming from and dependencies for our app.
			- `./:/app` - Looking at the Dockerfile you see that we are adding all local files to the container, and putting them in an `app` directory and making that our working directory. This means that everything in the directory is now in the container but this volume means that everything local stays in sync with our container.
		- `commands` - If you want to run a specific command on a container after it's been created and booted, here we are just running `npm start` which is defined in our Dockerfile.

If you wanted to just run the app from port 80, but keep express running at 3000 you would just change the port to `80:3000`

Running `docker-compose up` ( after all NPM install has completed ) you should see the following:

```bash
Creating expressapp_builder_1 ...
Creating expressapp_builder_1 ... done
Attaching to expressapp_builder_1
builder_1  | npm info it worked if it ends with ok
builder_1  | npm info using npm@5.4.2
builder_1  | npm info using node@v8.7.0
builder_1  | npm info lifecycle express-app@0.0.0~prestart: express-app@0.0.0
builder_1  | npm info lifecycle express-app@0.0.0~start: express-app@0.0.0
builder_1  |
builder_1  | > express-app@0.0.0 start /app
builder_1  | > nodemon ./bin/www
builder_1  |
builder_1  | [nodemon] 1.12.1
builder_1  | [nodemon] to restart at any time, enter `rs`
builder_1  | [nodemon] watching: *.*
builder_1  | [nodemon] starting `node ./bin/www`
builder_1  | GET / 304 239.574 ms - -
builder_1  | GET /stylesheets/style.css 304 4.607 ms - -
```
Now you can edit away!