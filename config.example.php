<?php
// Configuration for the Kindness Scanner
// Uncomment as desired.

/* The user-displayed title. */
// $ks_config['title'] = 'Kindness Scanner';

/* The root url for the project.
How should the web server be accessed by, e.g., scanned cards? */
$ks_config['root_url'] = 'https://my.example.com/path/to/KindnessScanner';

/* PostgreSQL database configuration */
$ks_config['db_host'] = 'localhost';
$ks_config['db_port'] = 5432;
$ks_config['db_name'] = 'somedatabase';
$ks_config['db_user'] = 'someuser';
$ks_config['db_password'] = 'somepassword';

/* The project directory.
This should be automatically detected if the web directory is symbolically linked into the web server.
This directory must be readable by the web server. */
// $ks_config['project_dir'] = '/some/path/to/KindnessScanner';
