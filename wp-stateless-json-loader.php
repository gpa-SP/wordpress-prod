<?php
/**
 * Plugin Name: WP Stateless Secret JSON Loader
 * Description: Carga automáticamente las credenciales JSON de WP-Stateless desde el secreto montado.
 * Version: 1.0
 * Author: OpenAI ChatGPT
 */

error_log('🔐 Intentando cargar JSON desde loader...');

add_filter('wp_stateless_service_account_json', function () {
    $path = '/secrets/SERVICE_ACCOUNT_JSON';
    if (!file_exists($path)) {
        error_log("❌ No se encontró el archivo JSON: $path");
        return [];
    }
    $json = json_decode(file_get_contents($path), true);
    error_log('✅ JSON cargado correctamente');
    return $json;
});
