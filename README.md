Done!
=====

"Done!" is a simple todo management application.


## Installation

### Step 0: Download Composer

The project is installed using Composer.

If there is no Composer installed in your system, it can be downloaded and installed following
the [Composer official documentation](http://getcomposer.org/doc/00-intro.md#installation-nix).

### Step 1: Install needed components and configure project using Composer

The project repository does not include packages of third-party vendors and needs some configuration to run with.

Let's install needed components and configure the project:
``` bash
$ php composer.phar install
```

### Step 2: Create database schema

Once the project is properly configured we can create its database and database schema:
``` bash
$ php app/console doctrine:database:create
$ php app/console doctrine:schema:create
```

### Step 3 (optional): Install database fixtures

If you want to use demo data, you can install predefined fixtures:
``` bash
$ php app/console doctrine:fixtures:load
```

After that you will be able to login to the demo account (login: demo@demo.demo, password: demo).

### Step 4: Run project

#### Built-in server
You can use PHP built-in server (PHP4 or higher) to run project:
``` bash
$ cd web
$ php -S <domain>:<port>
```

#### Web-server

Point your web-server root to the /web directory of the project.

### Final step: Try it!

Done! is now accessible in your browser:
- domain:port/app.php - production mode;
- domain:port/app_dev.php - development mode.

Note: It is up to you and your web server to get rid of the need to add /app.php while opening front page
in production mode.

## What needs to be done
- Tokens should be stronger;
- Login and security should be based on Symfony2 Security;
- Error reporting should be more bullet-proof structured;
- Inputs should be validated more carefully (still, there is no way system can be harmed by input for now);
- JavaScript code should be revised (for now its a pile of hairy crap);
- Tests! Tests! Tests! Tests! As for now it only was smoke-tested.

## Special thanks
- [Fabien Potencier](https://github.com/fabpot) and [SensioLabs](http://sensiolabs.com/), the creators of
[Symfony](https://github.com/symfony);
- [Gediminas Morkevicius](https://github.com/l3pp4rd), the creator
of [DoctrineExtensions](https://github.com/l3pp4rd/DoctrineExtensions),
and [Christophe Coevoet](https://github.com/stof), the creator
of [DoctrineExtensionsBundle](https://github.com/stof/DoctrineExtensionsBundle).