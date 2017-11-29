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
EXPOSE 8080 443
COPY docker/run.sh /
RUN chmod +x /run.sh
CMD ["/run.sh"]
