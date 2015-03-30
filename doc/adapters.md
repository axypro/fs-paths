# Adapters

An adapter provides methods for work with paths in specific file system.
Create an adapter as follows:

```php
$posix = Paths::getAdapter('posix');
$windows = Paths::getAdapter('windows');
$url = Paths::getAdapter('url');

$current = Paths::getAdapter(); // an adapter for the current environment
```

## Create Path Instance

```php
$path = $adapter->create('./../file.txt');

echo $path->isAbsolute; // false
```

Creates [a path instance](path.md) for the specific file system.

## Methods for Path Manipulation

* `isAbsolute(string $path):bool`
* `getDirName(string $path):string`
* `getFileName(string $path):string`
* `getBaseName(string $path [, string $ext]):string`
* `getExt(string $path):string`
* `getDirs(string $path):array`
* `getSubType(string $path):string`

Most of these methods are similar to the properties obtained from a path instance.

```php
$adapter->isAbsolute('/var/www');

// is equivalent to

$adapter->create('/var/www')->isAbsolute
```

See [documentation of path instance](path.md) for details about properties.

### `getBaseName(string $path [, string $ext])`

If the second argument is specified then base name will be returned if extension is equivalent.
Else will be returned `NULL`.

```php
$result = [];
foreach ($paths as $path) {
    $basename = $adapter->getBaseName('txt');
    if ($basename) {
        $result[] = $basename;
    }
}
```

It processed only txt-files.

### `normalize(string $path):string`

[Normalizes](resolve.md) a path.

```php
$path = '/one/two/../three/./four';

$adapter->normalize($path); // "/one/three/four"
```

### `resolve(string $base, string $relative):string`

[Resolves](resolve.md) a path relative to the base path.

```php
$base = '/var/www/site.com/htdocs/';
$relative = './../config/production.xml';
$path = $adapter->relative($base, $relative); // "/var/www/site.com/config/production.xml"
```

