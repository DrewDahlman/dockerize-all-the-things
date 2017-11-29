FROM ruby:2.3.1

# Install the basics...
RUN apt-get update -qq && apt-get install -y build-essential

# and for postgres...
RUN apt-get install -y libpq-dev

# and for js runtime...
RUN apt-get install -y nodejs

# Set an environment variable for the app home directory
# ENV APP_HOME /app

# Set up the app home directory in the container
# RUN mkdir $APP_HOME
WORKDIR /app
