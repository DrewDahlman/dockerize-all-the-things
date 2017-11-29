# Running Container
Sometimes you might just want to start a container and run all your commands inside of it - including adding dependencies to your app, starting your app, or configuring things. Luckily that is super easy to do as well.

If you look at the [crystal example](/crystal) you will see that our Dockerfile has `ENTRYPOINT ["tail", "-f", "/dev/null"]` this can be used to keep the container from exiting once it has run. 

Notice that in the [Express App](/express-app), [Legacy Rails](/legacy-rails-project) and [Wordpress](/wordpress) the container stays running, that is because each of those has a process that doesn't exit. You can define that process by using the `ENTRYPOINT` or by having a process start that doesn't exit on completion.

For this example we will be using the Dependencies example as our base, but a couple modifications to our docker-compose file and our Dockerfile and we can easily get into the container to add dependencies and run our app.

`docker-compose.yml`
```yml
version: '2'
services:  
  builder:
    build:
      context: .
      dockerfile: docker/Dockerfile
    volumes:
      - ./:/app
      - /app/node_modules
```
Notice we no longer have the command for after boot. That's because in our Dockerfile we have an entry point that keeps the container from exiting.

`docker/Dockerfile`
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

## Run npm install
RUN npm install

ENTRYPOINT ["tail", "-f", "/dev/null"]
```

If you run `docker-compose up` you will see that it boots up like normal, but instead of running and exiting it stays running. Open a new console and run `docker-compose exec builder bash`. This will ssh you into your container.
-	Full command `docker-compose exec <service> bash`

If you run `ls -la` you will see the project directory, but you are now inside of the container.

Run `npm start` - you will see the expected output but instead of exiting and stopping the container you're still in the container and can continue to execute commands.

Run `npm install random-words --save` and notice that your package.json has updated. 

Now update index.js from your IDE

```javascript
const _   = require('lodash');
const foo = [1,2,3,4,5,6,7,8,9,10];
let randomWords = require('random-words');

console.log("#####################################");
_.each( foo, (item) => {
  console.log(item + ' ' + randomWords());
});
console.log("#####################################");
```

Now run `npm start` and see the output of index.js with our random words.
