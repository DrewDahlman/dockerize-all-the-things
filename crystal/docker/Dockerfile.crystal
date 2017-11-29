## Use the crystal docker image
FROM crystallang/crystal

## Create a directory
RUN mkdir /app

## Set that as our working directory
WORKDIR /app
ADD docker_test /app

ENTRYPOINT ["tail", "-f", "/dev/null"]

