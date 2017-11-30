# Dockerize All The Things
Make your life easier by using containers for everything. This repo will walk through adding docker to your workflow and reducing the need to ever install deps ( Gems, Node Modules, etc ) on your system but instead rely on Docker for all of that. No more worrying about an update to osX to break all of your applications, because it's in a container you are free to just work.

## Intro
You know what is awful? Picking up a project that is using outdated versions that differ from your system. We have tools for that ( rbenv, RVM, NVM ) which help with this but you can still run into weird issues where even still things just don't work and you wind up spinning your wheels trying to get things to install and running before you can even start dev.

The purpose of this project is to show how radical using containers is and how you can avoid ever having to install dependencies on your system beyond the core essentials for scaffolding apps.

Using containers in this manner means teams can get spun up on projects faster and start contributing to the code. It also allows you to mirror environments so your dev and your production environments are always the same.

These examples are all fairly basic, but also should serve as a guide in dockerizing your dev workflow. These mainly are using docker compose v2+

## Tools
In order to run these code examples you will need the following:
- Docker
	- [OSX](https://docs.docker.com/docker-for-mac/install/)
	- [Windows](https://docs.docker.com/docker-for-windows/install/)
	- [Ubuntu](https://docs.docker.com/engine/installation/linux/docker-ce/ubuntu/)

That's it! 

## Examples
- [Docker Intro](intro) - Intro to docker
- [Dependencies](dependencies) - Working with dependencies
- [Running Container](running-container) - Running a container and sshing into it
- [Express App](express-app) - An existing express app
- [Docker Scaffold](docker-scaffold) - Scaffold an express app from Docker
- [Legacy Rails App](legacy-rails-project) - A legacy rails project
- [Wordpress](wordpress) - A fresh wordpress install 
- [Crystal](crystal) - Running and building a Crystal App
- [Docker Commands](docker-commands) - List of must know docker commands

## Further reading
I highly suggest going through the [docker documentation](https://docs.docker.com/) as well as using [Dockerhub](https://hub.docker.com/) to find images to use as your bases for Dockerfiles.

## Closing
The concepts here could be applied to any language, and setup. Through all of this I hope it's clear that with the right configuration you can easily dockerize anything including legacy apps to make your workflow easier and get your teams up and running faster with fewer headaches.


