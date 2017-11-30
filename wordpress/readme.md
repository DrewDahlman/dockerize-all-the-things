# Wordpress
Running a LAMP stack can sometimes be painful, sure you can install MAMP or WAMP but then you still have to deal with installing things locally that could potentially conflict with something else. 

## Running
- `docker-compose up`
- Visit http://localhost:8080

## Intro
Let's look at our `docker-compose.yml`

```yml
version: '2'
services:
  wordpress:
    build:
      context: .
      dockerfile: docker/Dockerfile.wordpress
    links:
      - db
    ports:
      - 8080:80
    volumes:
      - ./data:/data # Required if importing an existing database
      - ./:/app
    environment:
      DB_NAME: wordpress
      DB_PASS: root # must match below
      WP_DEBUG: 'true'
  db:
    image: mysql:5.7
    ports:
      - 3306:3306
    volumes:
      - data:/var/lib/mysql
    environment:
      MYSQL_ROOT_PASSWORD: root
volumes:
  data: {}
```

Again this looks similar to our other projects, in here we have a couple things that are different. We are setting environment variables. You can see we are also setting our wordpress to link to db which makes it available for use inside of wordpress. There is also a `run.sh` script in our docker directory that does some setup using wordpress-cli to configure our wp-config and such.

Looking at our `wp-config.php` we can see, just like the rails example, that we have a connection to our database using internals of docker.

```php
// ** MySQL settings ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'db:3306' ); // DB:PORT

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );
```

This docker compose file is also setting up our mysql server and setting up our initial database as well as user and password.

If you look at the `Dockerfile.wordpress` you can see the base image being used as well as installing of apache and setup.

```dockerfile
FROM tutum/apache-php

# Install mysql-client, unzip, git-all
RUN apt-get update \
    && DEBIAN_FRONTEND=noninteractive apt-get install -y --no-install-recommends \
        mysql-client \
        unzip \
        git-all \
        openssh-server \
        openssh-client \
        expect \
    && rm -rf /var/lib/apt/lists/*

# Install wp-cli, configure Apache, & add scripts
WORKDIR /app
ADD . /app
RUN curl \
        -o /usr/local/bin/wp https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar \
        -o /run.sh https://raw.githubusercontent.com/visiblevc/wordpress-starter/master/run.sh \
    && chmod +x /usr/local/bin/wp /run.sh \
    && sed -i "s/AllowOverride None/AllowOverride All/g" /etc/apache2/apache2.conf \
    && a2enmod rewrite \
    && service apache2 restart

# Run the server
EXPOSE 8080
COPY docker/run.sh /
RUN chmod +x /run.sh
CMD ["/run.sh"]
```

## Working
After you've run `docker-compose up` you can work on the site just as you normally would. A neat thing here is that you can export the database as a sql file and check that in so that your team can clone the repo and start off with the exact same setup without having to do anything.

To export the database just run `docker-compose exec wordpress sh -c "cd /data && wp db export --path=/app --allow-root"`

This will create a sql dump in a data directory. This is helpful in dev when the backend is being worked on and content, custom fields, acf or other plugins are being installed. All you have to do is remove the container and then build again by running `docker-compose build`
