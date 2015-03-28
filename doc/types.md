# Supported types of file systems

The library supports follows types of file systems: `posix`, `windows` and `url`.

## Posix

Unix-like file systems.

* Single root.
* The root is `/`.
* Directories separated by `/`.
* Directory name which contains `/` is unacceptable.
* `.` is current directory.
* `..` is parent directory.

`/one/two/three/file.txt` is absolute path.

`./../folder/file.txt` is relative path.

## Windows

The Windows-like file system has follow types of absolute paths:

* `c:\one\two\three.txt`
* `\one\two\three.txt`
* `\\ServerName\share\folder\file.txt`

Root in the first example is `c:\`.
In the third is `\\ServerName`.

* Directories separated by `/` or by `\`.
* Slashes `/` and `\` are equivalent.
* The library replaced `\` to `/` (`c:\one\two` -> `c:/one/two`)
* Directory name which contains `/` or `\` is unacceptable.
* Relative paths in Windows adapter are similar relative paths in Posix adapter.

## URL

This type was introduced for the calculation of relative paths in URLs.

Full view: `scheme://authority/path?query#fragment`

Example: `http://user:password@examle.loc:8080/folder/file.html?id=5#h1`.

The library works with `path` (`/folder/file.html` is the example).
