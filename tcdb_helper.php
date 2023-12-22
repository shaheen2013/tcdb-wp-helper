<?php
/*
Plugin Name: TCDB Helper
Plugin URI: https://mediusware.com
Description: A helper plugin for TCDB
Version: 1.0
Author: MEDIUSWARE
Author URI: https://mediusware.com/
License: GPLv2 or later
Text Domain: user-qr-code
Domain Path: /languages/
*/

/*function wordcount_activation_hook(){}
register_activation_hook(__FILE__,"wordcount_activation_hook");

function wordcount_deactivation_hook(){}
register_deactivation_hook(__FILE__,"wordcount_deactivation_hook");*/



function custom_user_columns($columns) {
    $columns['qr_code'] = 'Qr Code';
    return $columns;
}
add_filter('manage_users_columns', 'custom_user_columns');

// Display content for custom column
function custom_user_column_content($value, $column_name, $user_id) {
    if ($column_name == 'qr_code') {
        $uData = 'user_id='.$user_id;
        $qrImageUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=50x50&data='.$uData;
        $qrLinkUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=500x500&data='.$uData;
        return '<a target="_blank"  href="'.$qrLinkUrl.'"> <img src="'.$qrImageUrl.'" /></a>';
    }
    return $value;
}
add_filter('manage_users_custom_column', 'custom_user_column_content', 10, 3);


