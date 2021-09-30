<?php

/**
 * Project: SMF Topic Renamer
 * Version: 3.0
 * File: hooks.php
 * Author: digger @ https://mysmf.net
 * Author: dD#S aka BIOHAZARD @ http://simplemachines.org/community/index.php?action=profile;u=189535
 * License: The MIT License (MIT)
 *
 * To run this install manually please make sure you place this
 * in the same place and SSI.php and index.php
 */

global $context, $user_info;

if (file_exists(dirname(__FILE__) . '/SSI.php') && !defined('SMF')) {
    require_once(dirname(__FILE__) . '/SSI.php');
} elseif (!defined('SMF')) {
    die('<b>Error:</b> Cannot install - please verify that you put this file in the same place as SMF\'s index.php and SSI.php files.');
}

if ((SMF == 'SSI') && !$user_info['is_admin']) {
    die('Admin privileges required.');
}

if (!empty($context['uninstalling'])) {
    $call = 'remove_integration_function';
} else {
    $call = 'add_integration_function';
}

$hooks = array(
    'integrate_pre_include' => '$sourcedir/Mod-Dquote.php',
    'integrate_pre_load'    => 'Dquote::loadHooks',
);

foreach ($hooks as $hook => $function) {
    $call($hook, $function);
}

if (SMF == 'SSI') {
    echo 'Database changes are complete! <a href="/">Return to the main page</a>.';
}

/*

if (file_exists(dirname(__FILE__) . '/SSI.php') && !defined('SMF')) {
    require_once(dirname(__FILE__) . '/SSI.php');
} elseif (!defined('SMF')) {
    die('<b>Error:</b> Cannot install - please verify that you put this file in the same place as SMF\'s index.php and SSI.php files.');
}

if ((SMF == 'SSI') && !$user_info['is_admin']) {
    die('Admin privileges required.');
}

global $boardurl, $boarddir, $modSettings, $sourcedir, $smcFunc, $context;

// Hooks
$hooks = [
    'integrate_pre_include'      => '$sourcedir/TopicRenamer.php',
    'integrate_actions'          => 'TopicRenamer_actions',
    'integrate_mod_buttons'      => 'TopicRenamer_mod_buttons',
    'integrate_load_permissions' => 'TopicRenamer_permissions',
];

if (!empty($context['uninstalling'])) {
    $call = 'remove_integration_function';
} else {
    $call = 'add_integration_function';
}

foreach ($hooks as $hook => $function) {
    $call($hook, $function);
}

if (SMF == 'SSI') {
    echo 'Database changes are complete! Please wait...';
}
*/