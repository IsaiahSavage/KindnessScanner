# Kindness Scanner

## Internal Architecture
All files that must be served are in the `web` directory.

## Initial Setup
You must run the `get_composer.sh` or otherwise download [Composer](https://getcomposer.org/download/).
Then run `./composer.phar update` to download the necessary dependencies.

Place the `web` directory to be served by your web server.
This must either be symbolically linked, or it can be copied and the original project directory specified in the configuration file.

You must then copy `config.example.php` into the `web` directory as `config.php`, and edit it according to your setup.

### Example
From within the project directory:
```
$ ./get_composer.sh
$ ./composer.phar install
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

### Database administration
...

## Using the software
Once the software is installed and an administrator user is created, you are ready to begin.
Login with the administrator e-mail address and password.

At the main page, you have several options; you can:

* Go to your user settings
* Manage existing cards
* Manage existing users

### Example Walkthrough
At the main page, you can begin by adding a new user for someone else.

Go to *Manage Users* and fill out and submit the *Create New User* form. This will create an account and generate a temporary password that you can then send to that person so they can log in.

You can now create a card registered for that individual. Go to that user's settings, either from the creation page or from *Manage Users*. Select the *Create New Card* option. On the page for that card, you can generate a PDF with a QR code to print off as a physical card.

When that card is scanned, the scannee will be able to input their information and location and record the good deed before passing the card on to someone else. Scans will be displayed in the main map, as well as in the maps for each card.
