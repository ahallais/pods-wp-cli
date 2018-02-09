<?php
/*
Plugin Name: Pods - WP CLI
Description: Plugin to execute pods import csv
Version: 0.0.1
Author: Arnaud Hallais
License: GPL2
*/


/**
 * Define the plugin version
 */
define("PODSCLI", "0.0.1");


/**
 * The Pods_Cli class
 *
 * @package 	WordPress_Plugins
 * @author 		arnaud@hallais.com
 */
class Pods_Cli {

    function __construct() {
        function pods_command( $args ) {
            if (!file_exists($args[0])) {
                WP_CLI::print_value(WP_CLI::colorize('%rFile not found : %w '). $args[0]);
            } else {
                if (!class_exists('Pods_Migrate_Packages') ) {
                    WP_CLI::print_value(WP_CLI::colorize('%rError:%w Pods Migrate Packages Missing'));
                }
                else {
                    WP_CLI::print_value(WP_CLI::colorize('%yImporting : %w '). $args[0]);
                    $data = file_get_contents($args[0]);
                    $result = Pods_Migrate_Packages::import( $data, true );
                    foreach ($result["pods"] as $imported) {
                        WP_CLI::print_value(WP_CLI::colorize('%gImported: %w '. $imported));
                    }

                }

            }
        }
        if ( class_exists('WP_CLI_Command') ) {
            WP_CLI::add_command('pods', 'pods_command');
        }
    }

}

if ( class_exists('Pods_Cli') ) {
    $Pods_Cli = new Pods_Cli();
}