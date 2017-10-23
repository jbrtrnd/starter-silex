# Silex starter project

A project starter built with [Silex](https://silex.sensiolabs.org/) and [Doctrine](http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/). 
The first goal of this starter is to build rapid PHP API.

Be careful, this starter has a strong dependency with Silex and Doctrine, you should read the docs before starting.

## Table of content
* [Getting Started](#getting-started)
    * [Prerequisites](#prerequisites)
    * [Installing dependencies](#installing-dependencies)
    * [Run](#run)
* [Overview](#overview)
    * [Base project structure](#base-project-structure)
    * [Console mode](#console-mode)
* [Create your own module](#create-your-own-module)
    * [What is a Module ?](#what-is-a-module)
    * [Module skeleton](#module-skeleton)
    * [The Module class](#the-module-class)
    * [Controllers and Routes](#controllers-and-routes)
* [Automated Grunt tasks](#automated-grunt-tasks)
    * [Checking code style](#checking-code-style)
    * [Running tests](#running-tests)
    * [Generate API documentation](#generate-api-documentation)
    * [Running built-in PHP development server](#running-built-in-php-development-server)
    

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. 
Go to deployment section for notes on how to deploy the project on a live system.

This project starter is using [Grunt](https://gruntjs.com/) to manage integration tasks as checking code-style, running tests ... 

It also contains an ExampleModule to show you how to build a custom module. You should delete it if you want to use this starter for a projet.

### Prerequisites

* [npm](https://www.npmjs.com/get-npm) 

    Needed to install Javascript tools (e.g. Grunt plugins).

* [Composer](https://getcomposer.org/download/)

    Needed to install PHP tools and libraries (e.g. Silex, Doctrine, integration tools...).

* [Grunt](https://gruntjs.com/)
    
    A Grunt package is provided by npm with the ``package.json`` file but you may install it globally with the following command :
    
    ```shell
    npm install -g grunt
    ```

### Installing dependencies

At the root directory of the starter, run :

```shell
npm install
composer install
```

### Run

At the root directory of the starter, run :

```shell
grunt run
```

See [Running built-in PHP development server](#running-built-in-php-development-server) for more explanation.

## Overview

### Base project structure

```
|-- bin/
    |-- console        --> PHP executable file to run the console mode
|-- node_modules/      --> Javascript tools installed from NPM
|-- src/               --> Sources files root directory
    |-- modules/       --> Modules root directory (write your own modules here !)
        |-- Starter    --> Starter internal module, do not delete this directory !
        |-- Example    --> An example of custom module
    |-- public/        --> Root directory for webserver (should be the only web-accessible directory)
        |-- index.php  --> Document root
    |-- autoload.php   --> Project custom autoload needed to load modules
    |-- constants.php  --> Project global constants (e.g. paths to config, vendors, modules...)
|-- tests/
    |-- src/           --> Tests files root directory
        |-- Starter    --> Tests of the Starter module (do no delete)
    |-- utils/         --> Some tests utilities
    |-- bootstrap.php  --> PHPUnit bootstrap file
|-- vendor/            --> PHP integration tools and libraries installed from Composer
|-- .gitignore
|-- composer.json
|-- composer.lock
|-- Gruntfile.js       --> Grunt configuration file
|-- package.json
|-- package-lock.json
```

### Console mode

The starter provide a console mode based on the Symfony Console component.

At the root directory of the starter, run the following command to get the list of available commands :
```shell
php bin/console
```

To execute a specific command, run the following :
```shell
php bin/console <command>
```

## Create your own module

### What is a Module ?

In this starter, a module is a container for some business logic specific code. A module can contains its own Entities, 
Controllers, Routes, Middlewares, Services etc...

From the first steps, the source code contains two modules : the Starter Module and the Example Module.
The Starter Module contains the core code to run the starte, be careful to not delete it. The Example Module is just
some basic code to show you what you can do with a Module.

### Module skeleton

The first step to create your own Module is to create its directory in the ``src/module`` directory.
Be careful when naming this directory : it will be the Namespace prefix used by the autoloading to load your module classes.

The very basic structure of a Module is as follows :

```
|-- src/
    |-- modules/
        |-- MyModule/                   --> Root directory
            |-- config/                 --> Configuration directory (containing your *.config.php files)
            |-- src/                    --> Sources directory (containing your *.php files)
                |-- Module.php          --> The Module class
```

### The Module class

The Module class is necessary if you want to load your Module in the application (it will throw an error if the Module class 
isn't present).

```php
<?php
    
namespace MyModule;
    
use Starter\Core\Module\StarterModule;
    
class Module extends StarterModule
{
}
    
```

In the Module class you can overwrite two functions :

- ``afterLoad()``

To execute some code after your module has finished loading

- ``afterApplicationLoad()``

To execute some code after the application (all the modules) has finished loading

In this two functions, you can access the Silex application with the property ``$this->application``, so you can register
new services, add Doctrine functionalities etc...


### Controllers and Routes

For the example, we're creating a controller in the ``src/module/MyModule/src/Controller/`` directory with really basic actions.

```php
<?php
    
namespace MyModule\Controller;
    
use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
    
class IndexController
{
    public function __construct(Application $application)
    {
        /**
         * We can maybe retrieve some dependencies from the Silex global container or 
         * pass directly dependencies from the routes config file.
         */
    }
    
    public function myPage(): Response
    {
        return new Response('<!DOCTYPE html><html><body>An HTML page</body></html>');
    }
    
    
    public function myAction(): Response
    {
        return new Response('<!DOCTYPE html><html><body>An HTML page</body></html>');
    }
    
    public function myApi($id): JsonResponse
    {
        return new JsonResponse(['Some JSON data for the entity ' . $id]);
    }
}
    
```

A controller is only a class with methods as action returning HTTP responses. Read the [Service Controller documentation](https://silex.symfony.com/doc/2.0/providers/service_controller.html) to learn more.

Now we need to link theses two actions with some routing process.

The routing configuration of the application is made by PHP configuration files. Each module-specific configuration files should be 
located in the ``config`` directory of the module directory and be suffixed by ``*.config.php``.

So, let's create the ```routes.config.php``` file in the ``src/module/MyModule/config`` directory :


```php
<?php
    
namespace MyModule;
    
use Silex\Application;
    
return [
    'controllers' => [
        'myModule.controller.index' => function (Application $application) {
            return new Controller\IndexController($application);
        },
    ],
    'routes' => [
        '/myPage' => [  // URL
            'GET' => [  // HTTP METHOD
                'controller' => 'myModule.controller.index', // Controller name (defined just before)
                'action'     => 'myPage'                     // Function of the controller to use
            ],
            'POST' => [  // HTTP METHOD
                'controller' => 'myModule.controller.index', // Controller name (defined just before)
                'action'     => 'myAction'                   // Function of the controller to use
            ],
        ],
        '/myApi/{id}' => [      // Parametrized URL
            'GET,POST,PUT' => [ // HTTP METHODS
                'controller' => 'myModule.controller.index', // Controller name (defined just before)
                'action'     => 'myApi',                     // Function of the controller to use
            ],    
        ]
    ]
];
    
```

First, you have to declared your controllers in the ``controllers`` key of the configuration. Each controller must have a 
name (e.g. ``myModule.controller.index``) and a factory function used to instanciate the controller object. From this factory,
you have access to the Silex application object, so you can easilly pass some dependencies to your controller.

Now, it's time to define routes !

The ``routes`` key of the configuration file have to be an array of routes, indexed by the access url.
Inside this access url array, you can have one definition by HTTP method, or multiple HTTP methods for one definition (with comma separated list).

In this case, if we access the url ``localhost:8000/myPage`` with a GET http method, it will execute the ``myPage`` function of the ``IndexController`` 
(others http methods will not work and send a 405 Method Not Allowed response).
We can define differents controllers and functions depending on which method we're accessing the URL. We can also allow only certains HTTP methods
by don't put them in the array key.

## Automated Grunt tasks

All the following tasks must be ran at root directory of the starter.

### Checking code style
```shell
grunt style
```
Using [PHP_CodeSniffer ](https://github.com/squizlabs/PHP_CodeSniffer), configured to run in the ``src`` directory using PSR1/2 standard.


### Running tests
```shell
grunt test
```
Using [PHPUnit](https://github.com/sebastianbergmann/phpunit), configured to run in the ``tests`` directory.

### Generate API documentation
```shell
grunt doc
```
Using [phpDocumentor](https://www.phpdoc.org/), configured to run in the ``src`` directory. Will generate the HTML
documentation in the ``documentation`` directory. 


### Running built-in PHP development server
```shell
grunt run
```
Run the application with the built-in PHP server on the port ``8000`` from the ``src/public`` directory.
This will not replace a real webserver (eg. Apache, Nginx), so **it's not recommended to use it in production**.





