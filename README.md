# Kindness Scanner

## Internal Architecture
All files that must be served are in the `web` directory.

## Setup
Place the `web` directory to be served by your web server. This can be copied or symbolically linked.

### Example
From within the project directory:
```
$ ln -s `realpath web` /var/www/html/my/web/path
```

The project can then be run from `http://my.example.com/my/web/path`
