# File Name and Directory Name

For some actions we need to know, whether we are dealing with a file or a directory.

The library works with abstract paths as strings.
It does not make requests to the real file system.
It can not find out which is indicated by a path, and whether the path exists.

By default the library understands "the path" as the path to a file.
If a path ends with the directory separator (usually a slash) then it is path to a directory.

* `/var/www/robots.txt` - here directory name is `/var/www` and file name is `robots.txt`.
* `/var/www/` - it is directory name (file name is not defined).

Because of this unexpected behavior can occur.
For example the path `/var/www` for the library is the file `www` inside the directory `/var`.

This affects the behavior of algorithms [normalization and resolving](resolve.md).

For example, base path is `/one/two/three/`.
It is directory.
If relative path is `./four` then resulting path will be `/one/two/three/four`.

If base path is `/one/two/three` then it is file.
The directory is `/one/two`.
And resulting path will be `/one/two/four`.

## To better understand

There was URL: `http://example.loc/news/view/?id=10`.
The path of this page is `/news/view/`.
It is a directory.

On this page there is a link `../archive/`.
It point the full address `http://example.loc/news/archive/`.

If the base URL would be `http://example.loc/news/view.php?id=10` then it would be "file".
The current directory would be `/news/`.
And the link `../archive/` would lead to `http://example.loc/archive/`.

The library works in this case as well as browser.

## `..` and `.`

Such path components as `..` and `.` handled and normalized correctly.
`/one/two/..` is directory (equivalent to `/one/two/../`).

