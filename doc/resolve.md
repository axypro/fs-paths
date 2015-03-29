# Algorithm for Resolving

## Normalization

During normalization handled components such as `.` or `..`.

For example, for a path `/one/./two/three/../../four/five/../six` the normalization form is `/one/four/six`.

### Overflow

For absolute path can not rise above the root.

* `/one/two/../../../../../four/five` -> `/four/five`
* `c:\one\two\..\..\..\..\four\five` -> `c:/four/five`
* `\\Server\share\folder\..\..\..\new` -> `\\Server\new`

For relative it is possible.

* `one/two/../../../../three/four` -> `../../three/four`

## Resolving

```php
$path->resolve($base);
```

This method resolves the current path (`$path`) relative the basic path (`$base`).

For example:

* Basic path is `/home/user/folder/`
* Current path is `../../test/file.txt`
* Resulting path will be `/home/test/file.txt`

### Absolute Current Path

If the current path is absolute then resulting path will always be equal to it.
 
* Basic path is `/home/user/folder/`
* Current path is `/etc/passwd`
* Resulting path will be `/etc/passwd`

### Absolute Path in URL

URL has its own nuances.

To better understand the behavior, consider the following:

* Basic path is address of the page which opened in a browser.
* Current path is a link in the HTML-code of the page.
* Resolved path is address of the target page.

For example, basic path is `http://example.loc/one/two/page.html?x=1&y=2`.

If the current path is relative `../index.html?z=3` then resolved path will be `http://example.loc/one/index.html?z=3`.
The algorithm is the same as that for the normal path.
GET-parameters are replaced.

If the current path is absolute URL `http://site.loc/index.html` then resolved path equals to it.

If the current path is full path but without scheme and authority parts then path will be replaced 
but the domain will not be changed.
For `/news.php?id=5` it will be `http://example.loc/news.php?id=5`.

### Relative Basic Path

The basic path can be relative.
In this case, using the `..` you can rise above the begin.

For example:

1. Current directory is `/one/two`.
2. Relative path is `./three/four.html`.
3. `four.html` contains relative link `../../index.html`.

If you resolve to order (1+2) + 3: `/one/two/./three/../../index.html`.
Result is `/one/index.html`.

If resolve (3) relative (2) then result will be `../index.html`.
Resolving it relative (1) obtain again `/one/index.html`.

### Directory name and file name

The "path" is path to a file.
If the basic path is `/one/two/three.html` then basic directory is `/one/two`.
If the relative path is `../file.txt` then resulting path will be `/one/file.txt`.

In the path `/var/www` the directory is `/var` and `www` is file name (when in fact it is a directory).
Relative path `../file.txt` lead to `/file.txt` (not `/var/file.txt`).

Use trailing slash to specify directory (`/var/www/`).
