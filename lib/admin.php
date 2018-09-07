<?php

// uncomment next line to debug an error during activation
//include __DIR__ . "/debug.php";

if (get_option('webp-express-version', false) && (WEBPEXPRESS_VERSION != get_option('webp-express-version'))) {
    include __DIR__ . '/migrate/migrate.php';
}

include __DIR__ . '/options/options-hooks.php';

register_activation_hook(WEBPEXPRESS_PLUGIN, function () {
    include __DIR__ . '/activate.php';
});

register_deactivation_hook(WEBPEXPRESS_PLUGIN, function () {
    include __DIR__ . '/deactivate.php';
});

if (get_option('webp-express-messages-pending')) {
    include_once __DIR__ . '/classes/Messenger.php';
    add_action( 'admin_notices', function() {
        \WebPExpress\Messenger::printPendingMessages();
    });
}
if (get_option('webp-express-actions-pending')) {
    include_once __DIR__ . '/classes/Actions.php';
    \WebPExpress\Actions::processQueuedActions();
}

function webp_express_uninstall() {
    include __DIR__ . '/uninstall.php';
}

// interestingly, I get "Serialization of 'Closure' is not allowed" if I pass anonymous function
// ... perhaps we should not do that in the other hooks either.
register_uninstall_hook(WEBPEXPRESS_PLUGIN, 'webp_express_uninstall');


// Add settings link on the plugins page
add_filter('plugin_action_links_' . plugin_basename(__FILE__), function ( $links ) {
    $mylinks = array(
        '<a href="' . admin_url( 'options-general.php?page=webp_express_settings_page' ) . '">Settings</a>',
    );
    return array_merge( $links, $mylinks );
});
