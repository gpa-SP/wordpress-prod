<?php
define('DB_NAME', 'wordpress');
define('DB_USER', 'wp_user');
define('DB_PASSWORD', getenv('DB_PASSWORD'));
define('DB_HOST', getenv('DB_HOST'));

define('WP_STATELESS_MEDIA_BUCKET', getenv('WP_STATELESS_MEDIA_BUCKET'));
define('WP_STATELESS_MEDIA_MODE', getenv('WP_STATELESS_MEDIA_MODE') ?: 'stateless');
define('WP_STATELESS_MEDIA_CACHE_CONTROL', 'public,max-age=3600');
define('WP_STATELESS_MEDIA_USE_SERVICE_ACCOUNT', true);

define('DB_CHARSET', 'utf8');
define('DB_COLLATE', '');

define('AUTH_KEY',         'generate-me');
define('SECURE_AUTH_KEY',  'generate-me');
define('LOGGED_IN_KEY',    'generate-me');
define('NONCE_KEY',        'generate-me');
define('AUTH_SALT',        'generate-me');
define('SECURE_AUTH_SALT', 'generate-me');
define('LOGGED_IN_SALT',   'generate-me');
define('NONCE_SALT',       'generate-me');

$table_prefix = 'wp_';

// Migrar
define('AI1WM_BACKUPS_DIR', '/tmp/ai1wm-backups');
if (!file_exists(AI1WM_BACKUPS_DIR)) {
    mkdir(AI1WM_BACKUPS_DIR, 0777, true);
}


//define('WP_DEBUG', true);
//define('WP_DEBUG_DISPLAY', false);
//define('WP_DEBUG_LOG', false);
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false); // lo ideal en producción
@ini_set('display_errors', 0);


// no ftp message
define('FS_METHOD', 'direct');

if (!defined('ABSPATH'))
    define('ABSPATH', dirname(__FILE__) . '/');

$site_url = rtrim(getenv('URL'), '/');

if ($site_url && getenv('USE_WP_URLS') === 'true') {
    define('WP_HOME', $site_url);
    define('WP_SITEURL', $site_url);
}

if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
    $_SERVER['HTTPS'] = 'on';
}

if (!headers_sent()) {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
}
require_once ABSPATH . 'wp-settings.php';
