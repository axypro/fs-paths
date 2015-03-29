# Class Paths

The class `axy\fs\paths\Paths` provides static methods for work with paths.

## Create Adapter

```
getAdapter([string $fs]): adapter\Base
```

Returns an [adapter](adapters.md) for specified file system.

* `posix` or `Paths::TYPE_POSIX`
* `windows` or `Paths::TYPE_WINDOWS`
* `url` or `Paths::TYPE_URL`

```php
use axy\fs\paths\Paths;

$posix = Paths::getAdapter('posix');
$windows = Paths::getAdapter(Paths::TYPE_WINDOWS);

$posix->isAbsolute('c:\config.sys'); // false
$windows->isAbsolute('c:\config.sys'); // true
```

If the file system is not specified the adapter for current file system will be returned.

```php
$current = Paths::getAdapter();
```

## Create Path Instance

```
create(string $path [, string $fs]): Base
```

Returns a path instance for specified file system.
If the file system is not specified the path for current file system will be returned.

```php
$path = Paths::create('/home/user/file.txt');

echo $path->ext; // "txt"
```

## Methods for Path Manipulation

* `isAbsolute(string $path):bool`
* `getDirName(string $path):string`
* `getFileName(string $path):string`
* `getBaseName(string $path [, string $ext]):string`
* `getExt(string $path):string`
* `getDirs(string $path):array`
* `getSubType(string $path):string`

All these methods simply delegate the task to the current adapter.

`Paths::getDirName($path)` is equivalent of `Paths::getAdapter()->getDirName($path)`.

See [documentation of adapters](adapters.md) for details.
