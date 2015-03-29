# Static, Adapter, Path Instance

The library provides three ways to work with paths: static methods of `Paths`, adapter methods and work with instances of path.

## Class Paths

The class `axy\fs\paths\Paths` provides static methods for work with paths.
 
```php
use axy\fs\paths\Paths;

Paths::isAbsolute('/var/www/favicon.ico'); // true
Paths::getDirName('/var/www/favicon.ico'); // favicon.ico
Paths::resolve('/one/two/three', './../four'); // /one/four
```

These methods depend on the environment (Windows or Unix).

```php
Paths::isAbsolute('c:\config.sys'); // True on Windows and False on Unix
```

See [Paths class](Paths.md) for details.

## Adapters

The library provides adapters for each of supported file system (Posix, Windows or URL).

```php
$windows = Paths::getAdapter('windows');

$windows->isAbsolute('c:\config.sys'); // True, regardless of the environment
```

See [adapters](adapters.md) for details.

## Path instance

You can create an object for a specific path.

```php

$path = Paths::create('/var/www/favicon.ico');

$path->isAbsolute(); // true
$path->ext; // ico
$path->dirs; // ["var", "www"]
```

See [path instance](path.md) for detail.