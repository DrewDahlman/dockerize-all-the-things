# Dependencies
Now that we have a good grasp of how Docker works and the basic commands, let's actually start using it for dependencies.

For this example let's install lodash as a dependency and use it in our script. What we will see here is that all node_modules are installed on our docker container and not on our system.

## Running
- Run  `docker-compose up`

You will see the following output:

```bash
Creating network "dependencies_default" with the default driver
Building builder
Step 1/7 : FROM node:8.7.0
 ---> badd967af535
Step 2/7 : RUN apt-get update -qq && apt-get install -y build-essential
 ---> Using cache
 ---> 44d140bb3bfe
Step 3/7 : RUN mkdir /app
 ---> Using cache
 ---> c5db42ad9482
Step 4/7 : WORKDIR /app
 ---> Using cache
 ---> 5c25651058cc
Step 5/7 : ADD . /app
 ---> 3675ef1a4b88
Step 6/7 : RUN npm install
 ---> Running in 0b395d85c32e
npm info it worked if it ends with ok
npm info using npm@5.4.2
npm info using node@v8.7.0
npm info lifecycle dockerize-all-the-things-intro@1.0.0~preinstall: dockerize-all-the-things-intro@1.0.0
npm http fetch GET 200 https://registry.npmjs.org/lodash 279ms
npm http fetch GET 200 https://registry.npmjs.org/lodash/-/lodash-4.17.4.tgz 317ms
npm info lifecycle lodash@4.17.4~preinstall: lodash@4.17.4
npm info linkStuff lodash@4.17.4
npm info lifecycle lodash@4.17.4~install: lodash@4.17.4
npm info lifecycle lodash@4.17.4~postinstall: lodash@4.17.4
npm info linkStuff dockerize-all-the-things-intro@1.0.0
npm info lifecycle dockerize-all-the-things-intro@1.0.0~install: dockerize-all-the-things-intro@1.0.0
npm info lifecycle dockerize-all-the-things-intro@1.0.0~postinstall: dockerize-all-the-things-intro@1.0.0
npm info lifecycle dockerize-all-the-things-intro@1.0.0~prepublish: dockerize-all-the-things-intro@1.0.0
npm info lifecycle dockerize-all-the-things-intro@1.0.0~prepare: dockerize-all-the-things-intro@1.0.0
npm info lifecycle undefined~preshrinkwrap: undefined
npm info lifecycle undefined~shrinkwrap: undefined
npm notice created a lockfile as package-lock.json. You should commit this file.
npm info lifecycle undefined~postshrinkwrap: undefined
npm WARN dockerize-all-the-things-intro@1.0.0 No repository field.

added 1 package in 0.974s
npm info ok
 ---> de7184d43a12
Removing intermediate container 0b395d85c32e
Step 7/7 : EXPOSE 8080
 ---> Running in 4b57c284e708
 ---> 1efd3c42c181
Removing intermediate container 4b57c284e708
Successfully built 1efd3c42c181
Successfully tagged dependencies_builder:latest
WARNING: Image for service builder was built because it did not already exist. To rebuild this image you must use `docker-compose build` or `docker-compose up --build`.
Creating dependencies_builder_1 ...
Creating dependencies_builder_1 ... done
Attaching to dependencies_builder_1
builder_1  | npm info it worked if it ends with ok
builder_1  | npm info using npm@5.4.2
builder_1  | npm info using node@v8.7.0
builder_1  | npm info lifecycle dockerize-all-the-things-intro@1.0.0~prestart: dockerize-all-the-things-intro@1.0.0
builder_1  | npm info lifecycle dockerize-all-the-things-intro@1.0.0~start: dockerize-all-the-things-intro@1.0.0
builder_1  |
builder_1  | > dockerize-all-the-things-intro@1.0.0 start /app
builder_1  | > node index.js
builder_1  |
builder_1  | #####################################
builder_1  | 1
builder_1  | 2
builder_1  | 3
builder_1  | 4
builder_1  | 5
builder_1  | 6
builder_1  | 7
builder_1  | 8
builder_1  | 9
builder_1  | 10
builder_1  | #####################################
builder_1  | npm info lifecycle dockerize-all-the-things-intro@1.0.0~poststart: dockerize-all-the-things-intro@1.0.0
builder_1  | npm info ok
dependencies_builder_1 exited with code 0
```

Notice that now you have a `node_modules` in your directory, but there is nothing in there. This is created as a reference for our app but all modules are install on the container.

Check out `index.js`

```javascript
const _   = require('lodash');
const foo = [1,2,3,4,5,6,7,8,9,10];

console.log("#####################################");
_.each( foo, (item) => {
  console.log(item);
});
console.log("#####################################");
```

## What's next?
Try adding a new dependency to your package.json, maybe let's do [Random Words](https://www.npmjs.com/package/random-words)?

Note with this - you can still run `npm install random-words --save` and it will install the package, but notice that it now lives in node modules. This is fine but I would reccomend `rm -rf node_modules` after so that just your package.json was updated.

And let's update index.js

```javascript
const _   = require('lodash');
const foo = [1,2,3,4,5,6,7,8,9,10];
let randomWords = require('random-words');

console.log("#####################################");
_.each( foo, (item) => {
  console.log(item + ' ' + randomWords());
});
console.log("#####################################");
```

Now if you run `docker-compose up` again you will see the following:

```bash
Starting dependencies_builder_1 ...
Starting dependencies_builder_1 ... done
Attaching to dependencies_builder_1
builder_1  | npm info it worked if it ends with ok
builder_1  | npm info using npm@5.4.2
builder_1  | npm info using node@v8.7.0
builder_1  | npm info lifecycle dockerize-all-the-things-intro@1.0.0~prestart: dockerize-all-the-things-intro@1.0.0
builder_1  | npm info lifecycle dockerize-all-the-things-intro@1.0.0~start: dockerize-all-the-things-intro@1.0.0
builder_1  |
builder_1  | > dockerize-all-the-things-intro@1.0.0 start /app
builder_1  | > node index.js
builder_1  |
builder_1  | module.js:529
builder_1  |     throw err;
builder_1  |     ^
builder_1  |
builder_1  | Error: Cannot find module 'random-words'
builder_1  |     at Function.Module._resolveFilename (module.js:527:15)
builder_1  |     at Function.Module._load (module.js:476:23)
builder_1  |     at Module.require (module.js:568:17)
builder_1  |     at require (internal/module.js:11:18)
builder_1  |     at Object.<anonymous> (/app/index.js:3:19)
builder_1  |     at Module._compile (module.js:624:30)
builder_1  |     at Object.Module._extensions..js (module.js:635:10)
builder_1  |     at Module.load (module.js:545:32)
builder_1  |     at tryModuleLoad (module.js:508:12)
builder_1  |     at Function.Module._load (module.js:500:3)
builder_1  | npm info lifecycle dockerize-all-the-things-intro@1.0.0~start: Failed to exec start script
builder_1  | npm ERR! code ELIFECYCLE
builder_1  | npm ERR! errno 1
builder_1  | npm ERR! dockerize-all-the-things-intro@1.0.0 start: `node index.js`
builder_1  | npm ERR! Exit status 1
builder_1  | npm ERR!
builder_1  | npm ERR! Failed at the dockerize-all-the-things-intro@1.0.0 start script.
builder_1  | npm ERR! This is probably not a problem with npm. There is likely additional logging output above.
builder_1  |
builder_1  | npm ERR! A complete log of this run can be found in:
builder_1  | npm ERR!     /root/.npm/_logs/2017-11-29T18_15_05_839Z-debug.log
dependencies_builder_1 exited with code 1
```

This is erroring out because our container isn't aware that our package.json has been updated. To fix this just run `docker-compose rm` ( answer Y to remove the container ) then `docker-compose build builder`
- Note here the full command would be `docker-compose build <service>`
- Also note that we are remove the container, the reason for this is that sometimes the containers will hold on `docker-compose down`

After that run `docker-compose up` and you should see something like this:

```bash
Creating dependencies_builder_1 ...
Creating dependencies_builder_1 ... done
Attaching to dependencies_builder_1
builder_1  | npm info it worked if it ends with ok
builder_1  | npm info using npm@5.4.2
builder_1  | npm info using node@v8.7.0
builder_1  | npm info lifecycle dockerize-all-the-things-intro@1.0.0~prestart: dockerize-all-the-things-intro@1.0.0
builder_1  | npm info lifecycle dockerize-all-the-things-intro@1.0.0~start: dockerize-all-the-things-intro@1.0.0
builder_1  |
builder_1  | > dockerize-all-the-things-intro@1.0.0 start /app
builder_1  | > node index.js
builder_1  |
builder_1  | #####################################
builder_1  | 1 angle
builder_1  | 2 ability
builder_1  | 3 little
builder_1  | 4 surrounded
builder_1  | 5 stared
builder_1  | 6 mysterious
builder_1  | 7 far
builder_1  | 8 roar
builder_1  | 9 man
builder_1  | 10 safe
builder_1  | #####################################
builder_1  | npm info lifecycle dockerize-all-the-things-intro@1.0.0~poststart: dockerize-all-the-things-intro@1.0.0
builder_1  | npm info ok
dependencies_builder_1 exited with code 0
```

Give it a shot, play around with throwing any dependencies in there and using them!
