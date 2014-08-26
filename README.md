Meetspire
=========

Based on ZF2.

Installation
------------
To install this project please run:
```sh
vagrant up
php composer.phar install
grunt build
grunt watch
```

The project uses less to compile stylesheets. There are two ways to compile the css code from less:
* `grunt build` builds the css one time
* `grunt watch` watches for filechanges in assets/less and builds the css on a filechange
