# axy\fs-paths

[![Latest Stable Version](https://img.shields.io/packagist/v/axy/fs-paths.svg?style=flat-square)](https://packagist.org/packages/axy/fs-paths)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%205.4-8892BF.svg?style=flat-square)](https://php.net/)
[![Build Status](https://img.shields.io/travis/axypro/fs-paths/master.svg?style=flat-square)](https://travis-ci.org/axypro/fs-paths)

Manipulation of the file system paths.

* GitHub: [axypro/fs-paths](https://github.com/axypro/fs-paths)
* Composer: [axy/fs-paths](https://packagist.org/packages/axy/fs-paths)
* LICENSE: [MIT](LICENSE)
* Author: Oleg Grigoriev

PHP 5.4+

Library does not require any dependencies.

## Overview

The library provides functions for work with file paths.
Normalization, resolving and etc.

The library works with abstract paths.
No requests to the real file system.

## Contents

* [Supported types of file systems](doc/types.md)
* [Static, adapter, path instance](doc/features.md)
* [File Name and Directory Name](doc/dirname.md)
* [Paths Class](doc/Paths.md)
* [Adapters](doc/adapters.md)
* [Path Instance](doc/path.md)
* [Algorithms of Resolving and Normalization](doc/resolve.md)

## Examples

```php
use axy\fs\paths\Paths;

/* Static methods */
Paths::normalize('/one/two/../three'); // "/one/three"

/* Adapters */
$posix = Paths::getAdapter('posix');
$win = Paths::getAdapter('windows');

$posix->isAbsolute('c:\config.sys'); // False
$win->isAbsolute('c:\config.sys'); // True

/* Objects */
$url = Paths::getAdapter('url')->create('http://site.loc/news/view.php?id=10');
$url->resolve('../index.html#footer'); // http://site.loc/index.html#footer

$url->params->fragment; // "footer"
```

