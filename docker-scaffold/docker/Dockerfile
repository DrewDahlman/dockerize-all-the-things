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

## Comment this line after scaffolding the app
ENTRYPOINT ["tail", "-f", "/dev/null"]