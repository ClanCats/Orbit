# Orbit
Bundle structure for assets / resources and class autoloading.

## Register the Orbit autoloader

```php
ClanCats\Orbit\Manager::register([
	'cache' => __DIR__ . '/cache/',
]);
```

Map the main orbit.

```php
ClanCats\Orbit\Manager::map('main', __DIR__ . 'app/', '\\');
```

Add additional packages

```php
ClanCats\Orbit\Manager::map('example.repositories', __DIR__ . 'example/', '\\Example\\Repos\\');
```
