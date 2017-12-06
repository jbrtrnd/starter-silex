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
    * [Project configuration](#project-configuration)
        * [Doctrine DBAL configuration](#doctrine-dbal-configuration)
    * [REST architecture](#rest-architecture)
* [Create your own module](#create-your-own-module)
    * [What is a Module ?](#what-is-a-module-)
    * [Module skeleton](#module-skeleton)
    * [The Module class](#the-module-class)
    * [Controllers and Routes](#controllers-and-routes)
    * [Middlewares](#middlewares)
    * [Doctrine entities](#doctrine-entities)
    * [Console commands](#console-commands)
* [Create your own REST api](#create-your-own-rest-api)
    * [Entity serializing](#entity-serializing)
    * [Entity field validation](#entity-field-validation)
    * [Query relationships](#query-relationships)
* [Code generator](#code-generator)
* [Automated Grunt tasks](#automated-grunt-tasks)
    * [Checking code style](#checking-code-style)
    * [Running tests](#running-tests)
    * [Generate API documentation](#generate-api-documentation)
    * [Running built-in PHP development server](#running-built-in-php-development-server)
    * [Aliases](#aliases)
    

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
    |-- config/        --> Application global configuration
        |-- local/     --> Application local configuration
    |-- data/          --> Application data directory
        |-- proxies/   --> Used by Doctrine ORM to save entities proxies
    |-- module/        --> Modules root directory (write your own modules here !)
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

See [Console commands](#console-commands) to learn how to write your own commands.

### Project configuration

The starter allow you to define global configuration files. The configuration files are PHP files returning an array. They 
should resides in the ``src/config`` directory and be suffixed by ``*.config.php``.

The local configuration files (e.g. database connexion...) should be in the ``src/config/local`` directory as it's ignored
by the Git repository. 

The configuration will be loaded in the Silex container at the key ``starter.configuration`` as a ``Configuration`` 
object.

Example :
```php
<?php

return [
    'a-configuration-key' => 'some-value',
    'another-configuration-key' => [
        'foo', 'bar', 'baz'
    ]
];

```

#### Doctrine DBAL configuration

Copy the ``config/local/doctrine.config.template.php`` file  for ``config/local/doctrine.config.php`` and replace values
with yours.

```php
<?php


return [
    'doctrine' => [
        'dbal' => [
            'default' => [
                'driver'   => 'pdo_mysql',
                'host'     => 'localhost',
                'dbname'   => 'my_database',
                'user'     => 'my_user',
                'password' => 'my_password',
                'driverOptions' => [
                    1002 => 'SET NAMES utf8'
                ]
            ],
            'foo' => [
                'driver'   => 'pdo_mysql',
                'host'     => 'localhost',
                'dbname'   => 'another_database',
                'user'     => 'another_user',
                'password' => 'another_password',
                'driverOptions' => [
                    1002 => 'SET NAMES utf8'
                ]
            ]
        ]
    ]
];

```

You can set multiple connexions by adding entries in the ``doctrine.dbal`` key. They will be automatically injected in the
Silex application.

```php
$application['db']->fetchAll('SELECT * FROM table');
$application['dbs']['default']->fetchAll('SELECT * FROM table'); // Same as $application['db']
$application['dbs']['foo']->fetchAll('SELECT * FROM table');
```

The first connexion will be the default connexion used with ``$application['db']``.
See the Silex Doctrine [documentation](https://silex.symfony.com/doc/2.0/providers/doctrine.html).
Internally, the configuration entry ``doctrine.dbal`` will be mapped to the ``dbs.options`` used by the
Silex Doctrine provider.

You should write PHP test to check if your connexion is established and accessible. 

### REST architecture

This starter provide some classes allowing you to create a rapid JSON REST api. The REST architecture that you'll be able
to build is strongly linked to Doctrine ORM.

See [Create your own REST api](#create-your-own-rest-api) section to create your own REST api but read this chapter first.

When creating an entity, a controller and some routes linked to this controller functions, you can inherit some Starter 
classes that will allow you to simply build a REST api for this entity :

* ``Starter\Rest\RestEntity``
* ``Starter\Rest\RestController``
* ``Starter\Rest\RestRepository``

The ``RestController`` is designed to receive GET, PUT, POST and DELETE http requests and will send back to you some JSON response
with an HTTP status code representing the final state of your request. It will needs a link to the entity class of your 
``RestEntity``.

A ``RestController`` correctly mapped to its routes will produce the following api :

* **Search in the complete list of entities**

    ``GET : https://my.url.ext/some/route``
    
    Should be mapped to the ``search`` RestController action
    
    Response codes :
    * ``200`` : it's ok, entities retrieved
    * ``500`` : internal error
    
    Return an array of serialized entities on success.
    
    Query parameters :
    * ``page`` : index of the page (alias : ``_p``)
    * ``per_page`` : number of rows per page (alias : ``_pp``)
    * ``sort`` : sort columns, commas-separated  and prefixed by '-' for desc. order (eg : ``sort=-field1,field2``) (alias : ``_s``)
    * ``embed`` : embed properties not included in the default ``jsonSerialize`` entity function (eg : ``embed=field1,relation.field2``) (alias : ``_e``)
    * ``mode`` : perform a "and" or "or" query (default to "and") (alias : ``_m``)
    * ``<property-name>`` : filter by any entity property (operator will be equal by default) (eg: ``field1=value``)
    * ``<property-name>-<operator>`` : filter by any entity property and set the operator to apply, see Doctrine expr operators
    
    By default, all entities will be retrieved, you can pass query parameters to limit or filter results :
    A custom response header named "X-REST-TOTAL" will contain the total number of rows.

* **Retrieve an entity by its primary key value**
    
    ``GET : https://my.url.ext/some/route/:id``

    The ``:id`` route param must be always set.
    
    Should be mapped to the ``get`` RestController action.
    
    Response codes :
    * ``200`` : it's ok, entity retrieved
    * ``404`` : entity not found
    * ``500`` : internal error
    
    Query parameters :
    * ``embed`` : embed properties not included in the default ``jsonSerialize`` entity function (eg : ``embed=field1,relation.field2``) (alias : ``_e``)
        
    Return the retrieved serialized entity on success.

* **Create an entity**

    ``POST : https://my.url.ext/some/route``

    Request body with ``Content-type : application/json`` header:
    ``` 
    {
        "field_1": <FIELD1_VALUE>,
        "field_2": <FIELD2_VALUE>,
        ...
    }
    ```

    Should be mapped to the ``create`` RestController action
    
    Response codes :
    * ``200`` : it's ok, entity created
    * ``422`` : fields validation failed
    * ``500`` : internal error
    
    Query parameters :
    * ``embed`` : embed properties not included in the default ``jsonSerialize`` entity function (eg : ``embed=field1,relation.field2``) (alias : ``_e``)
    
    Return the created serialized entity on success or the fields validation errors.
   

* **Update an entity by its primary key value**

    ``PUT : https://my.url.ext/some/route/:id``
    
    Request body with ``Content-type : application/json`` header:
    ``` 
    {
        "field_1": <FIELD1_VALUE>,
        "field_2": <FIELD2_VALUE>,
        ...
    }
    ```
    
    The ``:id`` route param must be always set.

    Should be mapped to the ``update`` RestController action
    
    Response codes :
    * ``200`` : it's ok, entity updated
    * ``404`` : entity not found
    * ``422`` : fields validation failed
    * ``500`` : internal error
    
    Query parameters :
    * ``embed`` : embed properties not included in the default ``jsonSerialize`` entity function (eg : ``embed=field1,relation.field2``) (alias : ``_e``)
    
    You can partially update the entity.
    
    Return the updated serialized entity on success or the fields validation errors.

* **Remove an entity by its primary key value**

    ``DELETE : https://my.url.ext/some/route/:id``
    
    The ``:id`` route param must be always set.

    Should be mapped to the ``remove`` RestController action
    
    Response codes :
    * ``204`` : it's ok, entity removed
    * ``404`` : entity not found
    * ``500`` : internal error

    Return an empty response.

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
    |-- module/
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

In the Module class you can overwrite three functions :

- ``afterLoad()``

To execute some code after your module is loaded

- ``afterApplicationLoad()``

To execute some code after the application (all the modules) is loaded

- ``afterConsoleLoad(Console $console)``

To execute some code after the application (all the modules) is loaded in console mode 
(you can get the console application passed in parameters).

In this three functions, you can access the Silex application with the property ``$this->application``, so you can register
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

### Middlewares

As Silex provide the functionnality to affect "before" and "after" middlewares to routes we can do the same thing with the starter.

To create a Middleware, create a class which extends the abstract ``StarterMiddleware`` class. You must write the ``call()`` function that will be
called when the middleware will be executed (after and/or before).

To set the middleware to a route, let's get back to the routes configuration file :

```php
<?php
    
namespace MyModule;
    
use MyModule\Middleware\MyMiddleware;
use MyModule\Middleware\MySecondMiddleware;
use MyModule\Middleware\MyThirdMiddleware;
use Silex\Application;
    
return [
    ...
    'routes' => [
        '/myPage' => [  
            'GET' => [  
                'controller' => 'myModule.controller.index', 
                'action'     => 'myPage',                    
                'before'     => [               // The "before" middlewares for this route   
                    MyMiddleware::class, 
                    MySecondMiddleware::class           
                ],
            ],
            'POST' => [  
                'controller' => 'myModule.controller.index', 
                'action'     => 'myAction',                  
                'after'     => [                // The "after" middlewares for this route   
                    MyThirdMiddleware::class     
                ],
            ],
        ],
        ...
    ]
];
    
```

Just add the ``after`` and/or ``before`` key to your route definition with an array containing the classes of the middlewares
that you want to execute.

Inside the ``call()`` function, you'll have access to the ``$this->request`` (current HTTP request), ``$this->application``
(Silex application) and ``$this->response`` (current HTTP response, will be null if the middleware is called as a before middleware).
Return ``null`` if the request should continue to the next processing or return a ``Reponse`` if you want to stop the 
request processing at the middleware.

### Console commands

To write your own command, you'll have to do two steps :

First, create the command class :
```php
<?php

namespace MyModule\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SomeCommand extends Command
{
    protected function configure(): void
    {
        $this->setName('mymodule:some-command')
             ->setDescription('A custom command.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        // Code
    }
}
```

The command must inherits the ``Symfony\Component\Console\Command\Command`` class, you'll have to write two functions,
``configure`` (to define your command name and description) and ``execute`` (the code of you command). Take a look to the Symfony
documentation to learn more about commands.

Then, you'll have to tell the application to load your command. Commonly, this is done in the Module class of your custom
module, in the ``afterConsoleLoad`` function.

```php
<?php
    
namespace MyModule;
    
use MyModule\Command\SomeCommand;
use Starter\Core\Module\StarterModule;
    
class Module extends StarterModule
{
    public function afterConsoleLoad(Console $console): void
    {
        // Add your command to the application
        $console->add(new SomeCommand());
    }
}
    
```

Now, you can run your command by executing ``php bin/console mymodule:somecommand`` in a shell.

### Doctrine entities

To create new entities managed by Doctrine ORM, you'll have to create them in the ``Entity`` directory of your module ``src``.
Logically, your entities parent namespace will be`(and must be) ``YourModuleName\Entity``.

This starter use Doctrine annotations to configure entities members.

For example, an entity called ``MyEntity`` of the ``MyModule`` module must be located at
 ``src/modules/MyModule/src/Entity/MyEntity.php``.

```php
<?php
    
namespace MyModule\Entity;
    
/**
 * @Entity
 * @Table(name="mymodule_myentity")
 */
class MyEntity
{
    /**
     * @var int
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function setId(?int $id)
    {
        $this->id = $id;
    }
}
    
```

Launch the command ``php bin/console orm:schema-tool:update -f`` to update your database schema.

## Create your own REST api

Before going further, please be sure to fully understand the previous chapters [Create your own module](#create-your-own-module)
and [REST architecture](#rest-architecture).

To create your own REST api you'll have to user classes in the ``Starter\Rest`` namespace.

First, set up the entity by make it inherits the ``RestEntity`` class and set its default repository to the 
``RestRepository`` class :

```php
<?php
    
namespace MyModule\Entity;
    
use Starter\Rest\RestEntity;
    
/**
 * @Entity(repositoryClass="Starter\Rest\RestRepository")
 * @Table(name="mymodule_myentity")
 */
class MyEntity extends RestEntity
{
    ...
    
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            ...
        ];
    }
}
    
```

The ``repositoryClass="Starter\Rest\RestRepository"`` means that Doctrine will use the ``RestRepository`` as default 
repository class. If need some special treatment (joins, params processing...) you can extends this class to write you 
own repository and specify it in your entity (we'll see later how to custom your repository with the REST tools) :

```php
<?php
    
namespace MyModule\Repository;
    
use Starter\Rest\RestRepository;
    
class MyEntityRepository extends RestRepository
{
    ...
}
    
```

```php
<?php
    
namespace MyModule\Entity;
    
use Starter\Rest\RestEntity;
    
/**
 * @Entity(repositoryClass="MyModule\Repository\MyEntityRepository")
 * @Table(name="mymodule_myentity")
 */
class MyEntity extends RestEntity
{
    ...
}
    
```

Now let's define a REST controller for this entity :

```php
<?php
    
namespace MyModule\Controller;
    
use Silex\Application;
use Starter\Rest\RestController;
    
class MyEntityController extends RestController
{
    public function __construct(Application $application)
    {
        parent::__construct('MyModule\Entity\MyEntity', $application);
    }
}
    
```

You only have to inherits the ``RestController`` class, and pass the entity full class name inside the parent constructor.

You can obviously overwrite the ``RestController`` parents functions if you need some special treatments.

The last step is to create the associated routes with the correct HTTP methods :

```php
<?php
    
namespace MyModule;
    
use MyModule\Middleware\MyMiddleware;
use MyModule\Middleware\MySecondMiddleware;
use MyModule\Middleware\MyThirdMiddleware;
use Silex\Application;
    
return [
    'controllers' => [
        ...
        'myModule.controller.myEntity' => function (Application $application) {
            return new Controller\MyEntityController($application);
        },
    ],
    'routes' => [
        ...
        '/myEntity' => [
            'GET' => [
                'controller' => 'myModule.controller.myEntity',
                'action'     => 'search'
            ],
            'POST' => [
                'controller' => 'myModule.controller.myEntity',
                'action'     => 'create'
            ],
        ],
        '/myEntity/{id}' => [
            'GET' => [
                'controller' => 'myModule.controller.myEntity',
                'action'     => 'get'
            ],
            'PUT' => [
                'controller' => 'myModule.controller.myEntity',
                'action'     => 'update'
            ],
            'DELETE' => [
                'controller' => 'myModule.controller.myEntity',
                'action'     => 'delete'
            ],
        ],
        ...
    ]
];
    
```

From now, you have a full running REST api for you custom entity. But be careful, you can only query (via the ``search`` action)
the base fields of your entity (relations will not work for the moment).

### Entity serializing

The REST tools uses JSON as http response format. When an entity is retrieved (from search, get, create or update functions),
it will be render in the response.

You'll have to write yourself the process to convert your entity in an json format. This is why the ``RestEntity`` class 
implements the ``JsonSerializable`` interface. In your entity you must write the ``jsonSerialize`` function as follows :
 
 
```php
<?php
    
namespace MyModule\Entity;
    
use Starter\Rest\RestEntity;
    
/**
 * @Entity(repositoryClass="Starter\Rest\RestRepository")
 * @Table(name="mymodule_myentity")
 */
class MyEntity extends RestEntity
{
    ...
    
    public function jsonSerialize(): array
    {
        return [
            'id'     => $this->getId(),  // A property
            'foo'    => $this->getFoo(), // Another property
            'now'    => microtime(),     // A random property auto-calculated
            ...
        ];
    }
}
    
```

This function should return your serialized entity. By default, the ``RestController`` will use this function to serialize
your row(s) on each request.

Obviously, sometimes you'll need to retrieve some other data from your entities after an HTTP request. 
To achieve this goal, use the ``embed`` query parameter. The ``embed`` parameter us your entity getters, if you pass 
some property within this parameter, your entuty should include the corresponding ``getter`` function.

For example, if you query with ``?embed=field1``, your entity must include the public function ``getField1()``.

### Entity field validation

This starter use ``Zend\InputFilter`` to validate and filter input fields when creating or updating an entity.

Your entity class must implements the ``getInputFilter`` function that must return an instance of ``Zend\InputFilter\InputFilterInterface``.

You should be aware of the following : when creating or updating an entity, only presents fields in the entity inputFilter will
be retrieved to create/update the entity. If you send a field value and it's not present in the inputFilter, it will not 
be used.  

Please read the [Zend InputFilter documentation](https://docs.zendframework.com/zend-inputfilter/) to see the available options.

```php
<?php
    
namespace MyModule\Entity;
    
use Doctrine\ORM\EntityManager;
use Starter\Rest\RestEntity;
use Zend\InputFilter\Factory;
use Zend\InputFilter\InputFilterInterface;
    
/**
 * @Entity(repositoryClass="Starter\Rest\RestRepository")
 * @Table(name="mymodule_myentity")
 */
class MyEntity extends RestEntity
{
    ...
    
    public function getInputFilter(EntityManager $entityManager): InputFilterInterface
    {
        $factory = new Factory();
        return $factory->createInputFilter([
            'id' => [
                'required' => false
            ],
            'foo' => [
                'required' => true
            ],
            ...
        ]);
    }
}
    
```

### Query relationships

If your entity has some relationship (Many-to-Many, One-to-Many...) and you want to perform some search queries based on
theses relationships, you'll have to do some joins somewhere !

The ``RestRepository`` use its internal ``search`` function to build and execute a Doctrine ``QueryBuilder`` from params
retrieved via the ``RestController``.

Extending the ``RestRepository`` for your custom entity allows you to override two functions :
* ``beforeSearchCriteria(QueryBuilder $queryBuilder, ?array &$criteria): void``

Allows you to modify the criteria that will be used by the QueryBuilder.

* ``beforeSearchExecute(QueryBuilder $queryBuilder): void``

Allows you to modify the QueryBuilder just before it's execution (when completely configured).

Most of the time, you'll have to modify the QueryBuilder to add some joins to your query :

```php
<?php
    
namespace MyModule\Repository;
    
use Doctrine\ORM\QueryBuilder;
use Starter\Rest\RestRepository;
    
class MyEntityRepository extends RestRepository
{
    protected function beforeSearchCriteria(QueryBuilder $queryBuilder, ?array &$criteria): void
    {
        $queryBuilder->join('o.relation', 'relation');
        $queryBuilder->leftJoin('o.relation2', 'relation2');
        $queryBuilder->join('relation2.subRelation', 'subRelation');
    }
}
    
```

From now you can make an HTTP ``GET`` request to search your entities and query them by their relations.

First level relationships should be prefixed by ``o.``.

## Code generator

The starter provides commands allowing you to generate some code :

```shell
php bin/console starter:generate:module MyModule
```

Will generate an empty module.

```shell
php bin/console starter:generate:entity MyModule MyEntity
```

Will generate an empty REST entity in the defined module with controllers and routes.
As the generation will modify the file ``routes.config.php``, a backup file named ``routes.config.php-old`` will be 
created.

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

### Aliases

```shell
grunt validate
```

Runs ``style`` then ``test`` task.