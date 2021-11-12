# Kindness Scanner

## Internal Architecture
All files that must be served are in the `web` directory.

## Initial Setup
Place the `web` directory to be served by your web server. This can be copied or symbolically linked.

You must then copy `config.example.php` into the `web` directory as `config.php`, and edit it according to your setup.

### Example
From within the project directory:
```
$ ln -s `realpath web` /var/www/html/my/web/path
```

The project can then be run from `http://my.example.com/my/web/path`

## Low-level Administration
All administration scripts are contained in the `scripts` directory. To run these, `cd` to the `web` directory and run them as:

```
$ php ../scripts/info.php # Replace info.php with appropriate script.
```

These scripts will use the settings from `config.php`.

### Creating the database
From within the `web` directory, run the `create_db.php` script:

```
$ php ../scripts/create_db.php
```

### Setting up the admin user
Run the admin user setup script (`admin_setup.php`) to add a user from within the `web` directory:
```
$ php ../scripts/admin_setup.php
```

The wizard script will guide you through setup.
