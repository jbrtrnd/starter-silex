# Silex starter project

A project starter built with [Silex](https://silex.sensiolabs.org/) and [Doctrine](http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/).

## Table of content
* [Getting Started](#getting-started)
    * [Prerequisites](#prerequisites)
    * [Installing dependencies](#installing-dependencies)
    * [Run](#run)
* [Overview](#overview)
    * [Base project structure](#base-project-structure)
    * [Console mode](#console-mode)
* [Create your own module](#create-your-own-module)
* [Automated Grunt tasks](#automated-grunt-tasks)
    * [Checking code style](#checking-code-style)
    * [Running tests](#running-tests)
    * [Generate API documentation](#generate-api-documentation)
    * [Running built-in PHP development server](#running-built-in-php-development-server)
    

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. 
Go to deployment section for notes on how to deploy the project on a live system.

This project starter is using [Grunt](https://gruntjs.com/) to manage integration tasks as checking code-style, running tests ... 

### Prerequisites

* [npm](https://www.npmjs.com/get-npm) 

    Needed to install Javascript tools (e.g. Grunt).

* [Composer](https://getcomposer.org/download/)

    Needed to install PHP tools and libraries (e.g. Silex, Doctrine, integration tools...).

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

TODO

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





