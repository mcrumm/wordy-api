# Wordy API

An example project showcasing the features of [Guzzle](http://guzzlephp.org) Service Descriptions.

## Getting Started

1. Installing package dependencies with `composer install`.
2. Generate a Seed File

### Seed File

The following will generate an initial seed file, which should keep the API from throwing undue errors.

```
bin/console seed:generate
```

## Deployment

### PHP 5.4

If you're using PHP 5.4+, you can run the example API using the built-in web server. Here's the command:

```
php -S localhost:8787 -t web web/index.php
```

### Other

Explore the [Silex Docs](http://silex.sensiolabs.org/doc/web_servers.html) for more information on setting up other web servers.
