<?php

//$dotenv = \Dotenv\Dotenv::create(__DIR__ . '/../');
$dotenv = \Dotenv\Dotenv::createMutable(__DIR__ . '/../');
$dotenv->load();
// Should be set to 0 in production
getenv('ENVIRONMENT') == 'prod' ? error_reporting(0) : error_reporting(E_ALL);

// Should be set to '0' in production
getenv('ENVIRONMENT') == 'prod' ? ini_set('display_errors', '0') : ini_set('display_errors', '1');

// Timezone
date_default_timezone_set('Europe/Rome');

// Settings
$settings = [];

// Path settings
$settings['root'] = dirname(__DIR__);
$settings['temp'] = $settings['root'] . '/tmp';
$settings['public'] = $settings['root'] . '/public';
$settings['template'] = $settings['root'] . '/templates';

// Error Handling Middleware settings
if (getenv('ENVIRONMENT') == 'dev') {
    $settings['error'] = [

        // Should be set to false in production
        'display_error_details' => true,

        // Parameter is passed to the default ErrorHandler
        // View in rendered output by enabling the "displayErrorDetails" setting.
        // For the console and unit tests we also disable it
        'log_errors' => true,

        // Display error details in error log
        'log_error_details' => true,
    ];
} else {
    $settings['error'] = [

        // Should be set to false in production
        'display_error_details' => false,

        // Parameter is passed to the default ErrorHandler
        // View in rendered output by enabling the "displayErrorDetails" setting.
        // For the console and unit tests we also disable it
        'log_errors' => false,

        // Display error details in error log
        'log_error_details' => false,
    ];
}

// Database settings
$settings['db'] = [
    'driver' => \Cake\Database\Driver\Mysql::class,
    'host' => getenv('DB_HOST'),
    'username' => getenv('DB_USER'),
    'database' => getenv('DB_NAME'),
    'password' => getenv('DB_PASS'),
    // Enable identifier quoting
    'quoteIdentifiers' => true,
    // Set to null to use MySQL servers timezone
    'timezone' => null,
    // Disable meta data cache
    'cacheMetadata' => false,
    // Disable query logging
    'log' => false,
    'charset' => 'utf8mb4',
    'encoding' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'flags' => [
        // Turn off persistent connections
        PDO::ATTR_PERSISTENT => false,
        // Set connection timeout
        PDO::ATTR_TIMEOUT => 2,
        // Enable exceptions
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        // Emulate prepared statements
        PDO::ATTR_EMULATE_PREPARES => true,
        // Set default fetch mode to array
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        // Set character set
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci',
        // Convert numeric values to strings when fetching.
        // Since PHP 8.1 integers and floats in result sets will be returned using native PHP types.
        // This option restores the previous behavior.
        PDO::ATTR_STRINGIFY_FETCHES => true,
    ],
];


// Phoenix settings
$settings['phoenix'] = [
    'migration_dirs' => [
        'first' => __DIR__ . '/../resources/migrations',
    ],
    'environments' => [
        'local' => [
            'adapter' => 'mysql',
            'host' => getenv('DB_HOST'),
            'port' => 3306,
            'username' => getenv('DB_USER'),
            'password' => getenv('DB_PASS'),
            'db_name' => getenv('DB_NAME'),
            'charset' => 'utf8',
        ],
    ],
    'default_environment' => 'local',
    'log_table_name' => 'phoenix_log',
];

$settings['view'] = [
// Path to templates
    'path' => __DIR__ . '/../templates',
];

// Twig settings
$settings['twig'] = [
    // Template paths
    'paths' => [
        __DIR__ . '/../templates',
    ],
    // Twig environment options
    'options' => [
        // Should be set to true in production
        'cache_enabled' => false,
        'cache_path' => __DIR__ . '/../tmp/twig',
    ],
];

// Console commands
$settings['commands'] = [
    \App\Console\SchemaDumpCommand::class,
    \App\Console\SchemaImportCommand::class,
];

$settings['session'] = [
    'name' => 'mental_space',
    'cache_expire' => 0,
];

$settings['upload_directory'] = __DIR__ . '/../data';

// E-Mail settings
$settings['smtp'] = [
    // use 'null' for the null adapter
    'type' => getenv('MAIL_TYPE'),
    'host' => getenv('MAIL_SMTP'),
    'port' => getenv('MAIL_PORT'),
    'username' => getenv('MAIL_USER'),
    'password' => getenv('MAIL_PASS'),
];

$settings['jwt'] = [
// The issuer name
    'issuer' => 'app.mentalspace.com',
// Max lifetime in seconds
    'lifetime' => 14400,
// The private key
    'private_key' => '-----BEGIN RSA PRIVATE KEY-----
MIIEpgIBAAKCAQEA3d9EQPLog9R7TZKHxzLkBwfsq4vlASme7tWNNdS7zId0BipL
MO9H4RlfgoZIFY7oDfS7fVBMY27+wRD1K+ToqcmO+cfFZC2ZHZFWGly+W+EbkUX/
TYlMigYx9Ik+HmhabZHUcRDgfFK2pBpZmWbS5a1NVITS719O6t1xC40x9u2c4bDb
LS5IMR4A08Db/N5et39Kz6cCHo6TFTmBKzuL6imGaZdYWE0FPnL33aqCsff9xE7d
GZ4OeFGXw9XJmpiWhFGjttW+COhuMEIcwzWObqFdyksLFc5XkNWdGsCPfUmB8KUL
28R2WGd/rwUombVW9IwH8K02+9z8NPKzQsTxkQIDAQABAoIBAQCaV7RNUi05d9iG
sAZQJjDGS1byRxD5bBCpqFjhN6mksB2gJE/GLM5d4p60V+FRTeZTvwmmNPPOv+ns
OHW1ITpQ0mvpinTgKXA4R2AUWqv5knDw8DaXo4lhAspBiC90S7eMPUQBm3HuSkPP
iJ0Hv6W6LIJ85yEtb6mgbIc1N/WoBXue+JoDAjr1sufgiVdPflpppRyyZ31pdJaE
9upVwH3AtmMMlZrBJvki8Ce0ylmXDXmab9DYiYtvjTgYUwP+to3ptlvWzV8zsF3i
u1R0NxvJxksMyb+e2KoxWawSoUR27VfIPGhbSMDkZETjQdX0VNzBuq7uXOd66oPd
eBFGWGOBAoGBAPhFbn6mPqv3J4uLWaY1nbSl4tl1x4xRMNlIKf1eJqX76xUpWDLy
apVJ1MBSxhDl/5EFbgOaifhmrtJOS96HleFIrcVoi/CHgaeSEF01Jfr/Scg8KEVk
AihcX/c7P02Ec7YuBYfRwUwNvUAQwIkpcMG3XxH6V6zG6wrU+ImINRbZAoGBAOTH
c1rPnl5nGVexiVzsXDO+cMELr1O+9RRvFjCRYB+AuRTF9wb+II1BqdkiJRXYMclj
BAzURWZODWsfkBIf1S/kL7mH0MVyfV/DNu4bqGmHYuCi8QeoygLVP3Pff1TFVT9N
ZdI6UePnSm8DhLsqcW59hLwkPtgGMUGYPheiUS15AoGBAIxnf7iiPdk02ilhsl57
/ec21VbT8/kXxX9r/0spnsPJ90WtbxLI45vv+CCX7ymJWQHjxzbEg/h14bJP0zpT
BWE1oAh/OnzZtWpWAWkk8IjFLS3PT5sGlu3KZ/9Cg2dMW8AQwNHxvtZLAtcjYi9v
vzPehyZ8pG6yxCQJE1F8NUHpAoGBAIXxiEYovE4FCr9fAE9ZSvo4i4dasgHUEWUv
TMyOsLqBANt6tBByBNjvEuQ/q3rIow2HXT2tohwtoomPZyhVXtm1PYPgUojnaSQC
BU0PAGEYlPl0LK4RUoSqGYZb2g7loe14AR8+aeeG6PtqEfIK/XJ1JpuIlQqhRYFk
AyaPL/vxAoGBAK48zVUis0B0FVM5p0C3ND68wTVpdPWCgx03VUxU9GQ2mSCpOCe6
7HsTARI7dtsPx3OX2KMBdd+JQ3uikcwcjmvb7s3n2+ojGS5Nb9jov9lvxdFFx8oU
QliwCNKOp21dZaKqUQZsF6ArRwEXOR9ncQRaS7uxKu/NVtkkrs22gnPm
-----END RSA PRIVATE KEY-----',
    'public_key' => '-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA3d9EQPLog9R7TZKHxzLk
Bwfsq4vlASme7tWNNdS7zId0BipLMO9H4RlfgoZIFY7oDfS7fVBMY27+wRD1K+To
qcmO+cfFZC2ZHZFWGly+W+EbkUX/TYlMigYx9Ik+HmhabZHUcRDgfFK2pBpZmWbS
5a1NVITS719O6t1xC40x9u2c4bDbLS5IMR4A08Db/N5et39Kz6cCHo6TFTmBKzuL
6imGaZdYWE0FPnL33aqCsff9xE7dGZ4OeFGXw9XJmpiWhFGjttW+COhuMEIcwzWO
bqFdyksLFc5XkNWdGsCPfUmB8KUL28R2WGd/rwUombVW9IwH8K02+9z8NPKzQsTx
kQIDAQAB
-----END PUBLIC KEY-----',
];

return $settings;
