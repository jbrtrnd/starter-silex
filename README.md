# Silex starter project

A project starter built with [Silex](https://silex.sensiolabs.org/) and [Doctrine](http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/).

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. 
Go to deployment section for notes on how to deploy the project on a live system.

### Prerequisites

* [npm](https://www.npmjs.com/get-npm) 

    Needed to install Javascript tools.

* [Composer](https://getcomposer.org/download/)

    Needed to install PHP tools and libraries.

### Installing dependencies

```shell
npm install
composer install
```

### Automated Grunt tasks

#### Checking code style
PHP Code sniffer is configured to run in the ``src`` directory using PSR1/2 standard.
```shell
grunt phpcs
```

#### Running built-in PHP server
Run the application with the built-in PHP server on the port 8000.
```shell
grunt php
```




