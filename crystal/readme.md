# Crystal
[Crystal](https://crystal-lang.org/) is one of my new favorite languages, it's clean, powerful and written like ruby which I also enjoy a lot. This example is how you could create a container to run things on a VM and work only in the command line.

This is a great example of being able to start an app and run it without ever having to install the core language. Just run it in a container.

## Runnings
- `docker-compose up`

## Getting started
Let's start by looking at the `Dockerfile.crystal`

```bash
## Use the crystal docker image
FROM crystallang/crystal

## Create a directory
RUN mkdir /app

## Set that as our working directory
WORKDIR /app
ADD docker_test /app

## Leave the container running
ENTRYPOINT ["tail", "-f", "/dev/null"]
```

In this example we are leaving our container running after install and boot. This allows us to ssh into it and use the command line inside of our container.

Our `docker-compose.yml` file
```yml
version: '2'
services:  
  app:
    build:
      context: .
      dockerfile: docker/Dockerfile.crystal
    volumes:
      - ./docker_test/:/app

```
Just like our other examples we have our app and we're specifying our dockerfile as well as linked volumes. In this example I am linking only our crystal code into the container vs our whole directory.

## Commands
Once this is up and running we can now run our crystal app! In a new console run:
- `docker-compose exec app bash`
	- This will log us into our container to execute inside of it.

To see if this working let's run `crystal run src/docker_test.cr` you should see the following: 

```bash
hello world!
```

Now in your IDE edit that file and change the message and then in your console run that command again and you should see your message. This is showing that even though we're in a container our app is still referencing our code on our local machine.

Let's build a production version of the app! just run `crystal build src/docker_test.cr` After that you will see that a new file has been created on your system and that's the final executable from crystal. This was again all done using the container.