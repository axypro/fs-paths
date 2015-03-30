# Path Instance

Instance of the class `axy\fs\paths\Base` is wrapper on a string of path.
It allows to get information of the path and manipulated it.

## Create

There are several ways for create an instance.

```php
use axy\fs\paths\Paths;

$path1 = Paths::create('/file.txt'); // Path for current environment
$path2 = Paths::create('/file.txt', Paths::TYPE_POSIX); // Path for specified environment
```

```php
$adapter = Paths::getAdapter();

// ...

$path = $adapter->create('/file.txt');
```

```php
use axy\fs\paths\Posix;

$path = new Posix('/file.txt');
```

## Properties

The wrapper has properties that describe the path.
For optimality they are implemented as public properties.
Modify them directly is not recommended.

### `type`

The type of file system (Paths::TYPE_* constant): `posix`, `windows` or `url`.
 
```php
$path = Paths::create('/file.txt');

echo $path->type; // "posix" for Debian, for example
```

### `subType`

At the moment, one defined subtype: `server` for the paths of the form `\\ServerName\share\file.txt` on Windows platform.

In other cases it is `NULL`.

### `path`

The origin path string.

```php
$path = Paths::create('./../one.txt');
echo $path->path; // "./../one.txt"
```

For Windows slashes will be replaced to `/`.

```php
$path = Paths::create('c:\folder\file.txt', 'windows');
echo $path->path; // "c:/folder/file.txt"
```

### `isAbsolute`

Boolean flag: this path is absolute or relative.

Example absolute path for POSIX: `/var/www/robots.txt`.

Absolute for Windows:

* `c:\config.sys`
* `\folder\file.txt`
* `\\ServerName\share\file.txt`

For URL:

* `http://example.loc/index.html?id=5`
* `/index.html?id=5`

### `root`

The root of path.
For relative paths always is `NULL`.

For absolute POSIX paths is `/`.

For absolute Windows paths:

* `c:\config.sys` - `c:/`
* `\folder\file.txt` - `/`
* `\\ServerName\share\file.txt` - `//ServerName/`

For absolute URL paths:

* `http://example.loc/index.html?id=5` - `http://example.loc/
* `/index.html?id=5` - `/`

### `rel`

The part of paths relative the root.

For `c:\folder\file.txt` it is `folder\file.txt` on Windows.

For relative paths `rel` equals `path`.

### `dirName`

The directory of the path.

* `/var/www/file.txt` - `/var/www`.
* `http://example.com/folder/file.html?id=5` - `http://example.com/folder`

If the last component does not contain trailing slash it is consider as file.
If it contains slash - as directory.

* Directory name of `/var/www/file.txt/` - `/var/www/file.txt`

The library looks only at the string, not the real file system.
Directory name for a path `/var/www` will be `/var` and `www` consider as file name.

### `fileName`

The file name without the directory.

For URL `http://example.com/folder/file.html?id=5` file name is `file.html`.

For `/var/www/file.txt/` is `NULL`.
See `dirName` for details.

### `baseName`

The file name without the extension.

For path `/var/www/file.txt` the base name is `file`.
For `/var/www/file.txt/` is `NULL`.

For `ClassName.class.php` the base name is `ClassName.class` (only the last component is removed).

### `ext`

The extension of the file.

* for `/var/file.txt` is `txt`
* for `/var/file.txt.html` is `html`
* for `/var/file.txt.html/` is `NULL`
* for `http://example.com/folder/file.html?id=5` is `html`

Empty extension and no extensions are different cases

* for `/var/file` is `NULL`
* for `/var/file.` is empty string

### `dirs`

The list of components of directory name.

For `c:\one\two\three\four.txt` it is `["one", "two", "three"]`.

### `params`

This property contains an object with additional parameters of the path.
The set of parameters is different for the environment.

For `posix` it is empty object (additional parameters are not defined).

For `windows`:

* `disc` - the disc name. For `c:\config.sys` it is `c`.
* `server` - the server name. For `\\ServerName\share` it is `ServerName`.

For `url` (`http://user:password@example.loc:8080/folder/file.html?x=10#h1`):

* `scheme` (`http` from example)
* `authority` - `user:password@example.loc:8080`
* `query` - `x=10`
* `fragment` - `h1`

Missing components contain NULL.

NULL should be distinguished from the empty string:

* `/folder/file.html` - `query` is NULL
* `/folder/file.html?` - `query` is empty string
