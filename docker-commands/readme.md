# Docker Commands
A breakdown of Docker and Docker Compose commands.

## Intro
You can see the full list of commands by running `docker-compose --help` or `docker --help` These are the ones that you will mostly find yourself using when getting started.

### Basics
- `docker-compose ps` - Lists any running containers and their current status / port 
- `docker-compose up` - Starts docker 
- `docker-compose down` - Stops all running containers
- `docker-compose rm` - Removes containers
- `docker-compose down -v` - Stops containers and removes any linked volumes ( this may be good when you want to wipe a database or any linked volumes )
- `docker images` - Lists all docker images

### Kill it with fire
- `docker rm $(docker ps -a -q)` - Kills all containers
- `docker rmi $(docker images -q)` - will toast ALL of your images

Something to keep in mind is that sometimes docker containers and images can get bloated on your machine and you might have to toast everything. The great thing about using docker like this is that you can quickly rebuild a project and get right back into working.

Also when you close a console you are not stopping the container, you always need to run `docker-compose down` when stopping a project, otherwise it will just keep running in the background.

## Further reading
I highly suggest going through the [docker documentation](https://docs.docker.com/) as well as using [Dockerhub](https://hub.docker.com/) to find images to use as your bases for Dockerfiles.