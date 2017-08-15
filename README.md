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
* [Configuration](#configuration)
* [HTTP Routing](#http-routing)
* [Console Commands](#console-commands)
* [Dependency Injection](#dependency-injection)
* [Out of the box](#out-of-the-box)
    * [Cache](#cache)
    * [ORM](#orm)
    * [View](#view)
    * [Imagix](#imagix)
    * [Debug Bar](#debug-bar)
* [Service Providers](#service-providers)
* [Testing](#testing)
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

### Run

Open terminal and start docker containers from the project root directory.

`docker-compose up`

Wait until the `app` container is started and open in browser `http://127.0.0.1/`.

> It will take a while for the first time until it will download and build images.
> But next times containers will start faster.

**Optionally**, you can add an alias in `hosts` file `127.0.0.1 app.local` and open in browser `http://app.local/`.

# Configuration

All configuration files are stored in the `config` directory. You can easily access them from application:

```php
$app->config('debug');
```

### Environment variables

Environment variables are stored in `.env` file and could be accessed anywhere in the code, mostly in configuration files:

```php
'debug' => (bool) getenv('DEBUG'),
```

# License

MIT © [Grigorii Duca](http://greg.md)

# Huuuge Quote

![I fear not the man who has practiced 10,000 programming languages once, but I fear the man who has practiced one programming language 10,000 times. &copy; #horrorsquad](http://greg.md/huuuge-quote-fb.jpg)
