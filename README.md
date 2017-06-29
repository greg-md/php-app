# Greg PHP Application

[![StyleCI](https://styleci.io/repos/72987376/shield?style=flat)](https://styleci.io/repos/72987376)
[![Build Status](https://travis-ci.org/greg-md/php-app.svg)](https://travis-ci.org/greg-md/php-app)
[![Total Downloads](https://poser.pugx.org/greg-md/php-app/d/total.svg)](https://packagist.org/packages/greg-md/php-app)
[![Latest Stable Version](https://poser.pugx.org/greg-md/php-app/v/stable.svg)](https://packagist.org/packages/greg-md/php-app)
[![Latest Unstable Version](https://poser.pugx.org/greg-md/php-app/v/unstable.svg)](https://packagist.org/packages/greg-md/php-app)
[![License](https://poser.pugx.org/greg-md/php-app/license.svg)](https://packagist.org/packages/greg-md/php-app)

This Application is based on [Greg PHP Framework](https://github.com/greg-md/php-framework) and it's components.

# Table of Contents

* [Requirements](#requirements)
* [Installation](#installation)
* [Run](#run)
* [Builtin Components](#builtin-components)
* [Out of the box](#out-of-the-box)
* [License](#license)
* [Huuuge Quote](#huuuge-quote)

# Requirements

* [Docker](https://www.docker.com/)

# Installation

**Composer**

`composer create-project greg-md/php-app`

**Git**

`git clone https://github.com/greg-md/php-app.git`

**Manually**

[Download](https://github.com/greg-md/php-app/archive/master.zip) and unzip it in your preferable directory.

# Run

Open terminal and start docker containers from the project root directory.

`docker-compose up`

Wait until the `app` container is started and open in browser `http://127.0.0.1/`.

**Optionally**, you can add an alias in `hosts` file `127.0.0.1 app.local` and open in browser `http://app.local/`.

# Builtin Components

Main components:

* **Greg PHP Framework** - Greg Framework provides you a lightweight engine for fast creating powerful apps. [Documentation](https://github.com/greg-md/php-framework);
    * **Greg PHP Dependency Injection** - Dependency Injection technique for PHP. [Documentation](https://github.com/greg-md/php-dependency-injection);
    * **Greg PHP Routing** - A powerful Router for PHP. [Documentation](https://github.com/greg-md/php-routing);
    * **Symfony Console Component** - The Console component eases the creation of beautiful and testable command line interfaces. [Documentation](http://symfony.com/doc/current/components/console.html).
    * **Greg PHP Support** - Support classes for PHP. [Documentation](https://github.com/greg-md/php-support);
* **Greg PHP Cache** - A powerful Cache Manager for PHP. [Documentation](https://github.com/greg-md/php-cache);
* **Greg PHP ORM** - A powerful ORM(Object-Relational Mapping) for PHP. [Documentation](https://github.com/greg-md/php-orm);
* **Greg PHP View** - A powerful Viewer for PHP. [Documentation](https://github.com/greg-md/php-view);
* **Greg PHP Static Image** - Save images as static in real-time in different formats using [Intervention Image](http://image.intervention.io/). [Documentation](https://github.com/greg-md/php-static-image);
* **PHP Debug Bar** - Debugging in PHP has never been easier. [Documentation](http://phpdebugbar.com/);
* **Phinx** - PHP Database Migrations For Everyone. [Documentation](https://phinx.org/);
* **Symfony VarDumper Component** - The VarDumper component provides mechanisms for extracting the state out of any PHP variables. [Documentation](https://symfony.com/doc/current/components/var_dumper.html).

Testing components:

* **PHPUnit** - PHPUnit is an instance of the xUnit architecture for unit testing frameworks. [Documentation](https://phpunit.de/).

# Out of the box

# License

MIT © [Grigorii Duca](http://greg.md)

# Huuuge Quote

![I fear not the man who has practiced 10,000 programming languages once, but I fear the man who has practiced one programming language 10,000 times. &copy; #horrorsquad](http://greg.md/huuuge-quote-fb.jpg)
