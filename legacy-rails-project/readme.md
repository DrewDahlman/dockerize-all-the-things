# Legacy Rails Project
Running a legacy rails app in docker!

## Intro
Up to this point we have been using new apps as our examples. So let's see the real magic. This app is an old Rails 4.2.1 project. I have rails 5 installed on my local machine, normally this is a good example of when you will run into conflicts between versions of gems and such, but Docker is going to help us ensure we have a compatible environment for this app to run just fine!

## Running
- `cd app`
- `docker-compose up`

You will notice we have the same structure as our other examples here, a Dockerfile as well as a `docker-compose.yml` but they are pretty different and much more blown out.

```yml
version: '2'
services:
  bundle:
    image: ruby:latest
    command: /bin/true
    volumes:
      - /bundle
  db:
    image: postgres
    ports:
      - "5432:5432"
    environment:
      - POSTGRES_USER=dev
      - POSTGRES_PASSWORD=secret
    volumes:
      - "db-data:/var/lib/postgresql/data"
  app:
    build: config/docker
    command: bash -c "rm -f tmp/pids/server.pid && bundle install && bundle exec rake db:create && bundle exec rake db:migrate && bundle exec rails s -p 3000 -b '0.0.0.0'"
    environment:
      - BUNDLE_GEMFILE=/app/Gemfile
      - BUNDLE_JOBS=7
      - BUNDLE_PATH=/bundle
    volumes:
      - .:/app
      - .:/data
    volumes_from:
      - bundle
      - db
    ports:
      - "3000:3000"
    depends_on:
      - db

volumes:
  db-data:
```

We now have a number of services and bundles, as well as just using images vs our own Dockerfiles.

Some things to look at is how they are all being connected. In this example each of these services is it's own container, in order for them to work together we have to make them aware of eachother.

To do this we use `volumes_from` which allows docker to connect these containers. Some magic is done behind the scenes here and we get some neat features.

There is more information in the readme inside of app that describes in more detail what is happening and how it's working.

