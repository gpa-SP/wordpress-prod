<?php
echo "<h2>WP Stateless Diagnostic</h2>";
echo "<pre>";

if (function_exists('wp_stateless_bootstrap')) {
    echo "✅ WP Stateless está cargado.\n";
} else {
    echo "❌ WP Stateless NO está cargado.\n";
}

echo "\nConstantes de configuración:";
echo "\nWP_STATELESS_MEDIA_BUCKET: " . (defined('WP_STATELESS_MEDIA_BUCKET') ? WP_STATELESS_MEDIA_BUCKET : 'No definida');
echo "\nWP_STATELESS_MEDIA_MODE: " . (defined('WP_STATELESS_MEDIA_MODE') ? WP_STATELESS_MEDIA_MODE : 'No definida');
echo "\nWP_STATELESS_MEDIA_USE_SERVICE_ACCOUNT: " . (defined('WP_STATELESS_MEDIA_USE_SERVICE_ACCOUNT') ? (WP_STATELESS_MEDIA_USE_SERVICE_ACCOUNT ? 'true' : 'false') : 'No definida');

if (class_exists('wpCloud\StatelessMedia\Bootstrap')) {
    $bootstrap = wpCloud\StatelessMedia\Bootstrap::get_instance();
    $bucket = $bootstrap->get('sm')->getClient()->getBucket();
    echo "\nBucket detectado por plugin: " . ($bucket ? $bucket : '❌ No detectado');
} else {
    echo "\nNo se pudo inicializar Bootstrap de WP Stateless.";
}

echo "</pre>";
?>