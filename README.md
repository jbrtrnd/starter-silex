# Silex starter project

A project starter built with [Silex](https://silex.sensiolabs.org/) and [Doctrine](http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/).

## Table of content
* [Getting Started](#getting-started)
    * [Prerequisites](#prerequisites)
    * [Installing dependencies](#installing-dependencies)
* [Automated Grunt tasks](#automated-grunt-tasks)
    * [Checking code style](#checking-code-style)
    * [Running tests](#running-tests)
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

At the root directory of the starter run :

```shell
npm install
composer install
```

## Automated Grunt tasks

All the following tasks must be ran at root directory of the starter.

### Checking code style
```shell
grunt style
```
[PHP_CodeSniffer ](https://github.com/squizlabs/PHP_CodeSniffer) is configured to run in the ``src`` directory using PSR1/2 standard.


### Running tests
```shell
grunt test
```
[PHPUnit](https://github.com/sebastianbergmann/phpunit) is configured to run in the ``tests`` directory.


### Running built-in PHP development server
```shell
grunt run
```
Run the application with the built-in PHP server on the port 8000 from the ``src/public`` directory.
This will not replace a real webserver (eg. Apache, Nginx), so it's not recommended to use it in production.





