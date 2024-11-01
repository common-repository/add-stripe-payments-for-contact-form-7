<?php

/**
 * autoloader.
 *
 * From:
 * https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader-examples.md#class-example
 *
 * @param string $class The fully-qualified class name.
 *
 * @return void
 */
spl_autoload_register(function ($class) {
    // project-specific namespace prefix
    $namespaces = array(
        'SP4CF7\\'          => SP4CF7_PATH . 'includes/classes/',
        'SP4CF7\\_Admin\\'  => SP4CF7_PATH . 'admin/',
        'SP4CF7\\_Public\\'	=> SP4CF7_PATH . 'public/',
        'Stripe\\'          => SP4CF7_PATH . 'includes/stripe/lib/',
    );
    
    foreach ( $namespaces as $prefix => $base_dir ) {
        // base directory for the namespace prefix
        // does the class use the namespace prefix?
        $len = strlen($prefix);
        if (strncmp($prefix, $class, $len) !== 0) {
            // no, move to the next registered autoloader
            continue;
        }
        // get the relative class name
        $relative_class = substr($class, $len);
        // replace the namespace prefix with the base directory, replace namespace
        // separators with directory separators in the relative class name, append
        // with .php
        $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

        // if the file exists, require it
        if (file_exists($file)) {
            require $file;
        }
    }
});