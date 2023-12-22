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
        $qrLinkUrl = '/wp-admin/admin.php?page=custom_user_details_page&'.$uData;
        return '<a target="_blank"  href="'.$qrLinkUrl.'"> <img src="'.$qrImageUrl.'" /></a>';
    }
    return $value;
}
add_filter('manage_users_custom_column', 'custom_user_column_content', 10, 3);

function custom_admin_page_menu() {
    add_submenu_page(
        null,              // Parent menu slug (null to hide from the menu)
        'User Details',     // Page title
        'User Details',     // Menu title
        'manage_options',  // Capability required to access the page
        'custom_user_details_page',// Menu slug
        'custom_user_details_page' // Callback function to display page content
    );
}
add_action('admin_menu', 'custom_admin_page_menu');

// Callback function to display the page content
function custom_user_details_page() {

    $userCID = isset( $_GET['user_id']) ? $_GET['user_id'] : null;
    $qrImageUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=user_id='.$userCID;
    $user = get_user_by('ID', 2);
    echo '<div class="wrap">
<h1>User Details</h1>

<table class="form-table" role="presentation">

<tbody>
<tr>
<th scope="row">
<label for="blogname">Name</label>
</th>
<td>'. $user->user_nicename.'</td>
</tr>

<tr>

<tr>
<th scope="row">
<label for="blogname">Email</label>
</th>
<td>'. $user->user_email.'</td>
</tr>

<tr>
<th scope="row">
<label for="blogname">User Qr Code</label>
</th>
<td>

<img style="border-radius: 10px;border: 5px solid #FFF" src="'.$qrImageUrl.'" />
</td>
</tr>

</tbody>
</table>
</div>';
}

