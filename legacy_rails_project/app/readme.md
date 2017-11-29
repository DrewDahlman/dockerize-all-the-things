Docker Rails
==================

Super simple setup for Rails & Docker! This is super bare bones, but shows off what makes docker super neat to work with.

## Setup
- have docker installed ( https://docs.docker.com/docker-for-mac/install/ )

## Run
- `docker-compose up` ( this will create your containers and install gems, create the db and run migrate as well as start the webrick server )
- To ssh into the app `docker-compose exec docker_rails_app bash` and you will now be ssh'd into the container to do as you please, maybe running `rails g controller Example` or something.

## Docker Compose

This creates our bundle container and DB
<pre>
bundle:
	container_name: docker_rails
	image: ruby:latest
	command: /bin/true
	volumes:
		- /bundle
db:
	container_name: docker_rails_db
	image: postgres
	ports:
		- "5432:5432"
	environment:
		- POSTGRES_USER=dev
		- POSTGRES_PASSWORD=secret
	volumes:
		- "db-data:/var/lib/postgresql/data"
</pre>

you'll notice later when we define our app we reference these, essentially we are referencing how these containers come together.
<pre>
app:
  container_name: docker_rails_app
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
</pre>

## Interesting
Something interesting that docker gives you is an alias for things like the DB ( notice the host, rather than localhost we use just db as that is an internal connection for our containers )
<pre>
development:
  adapter: postgresql
  encoding: unicode
  database: docker_rails_db
  pool: 5
  username: dev
  password: secret
  host: db
</pre>
