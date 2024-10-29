<?php

/**
 * Plugin Name: Oportunamente
 * Plugin URI: https://agencialaf.com
 * Description: Descrição do Oportunamente.
 * Version: 0.0.1
 * Author: Ingo Stramm
 * Text Domain: op
 * License: GPLv2
 */

defined('ABSPATH') or die('No script kiddies please!');

define('OP_DIR', plugin_dir_path(__FILE__));
define('OP_URL', plugin_dir_url(__FILE__));

function op_debug($debug)
{
    echo '<pre>';
    var_dump($debug);
    echo '</pre>';
}

require_once 'tgm/tgm.php';
// require_once 'classes/classes.php';
// require_once 'scripts.php';
require_once 'cmb.php';
require_once 'shortcodes.php';
require_once 'endpoints.php';

require 'plugin-update-checker-4.10/plugin-update-checker.php';
$updateChecker = Puc_v4_Factory::buildUpdateChecker(
    'https://raw.githubusercontent.com/IngoStramm/oportunamente/master/info.json',
    __FILE__,
    'op'
);
