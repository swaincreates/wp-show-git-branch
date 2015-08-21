<?php
/*
 * Plugin Name: Show Git Branch
 * Version: 1.0
 * Plugin URI: https://github.com/swaincreates/wp-show-git-branch
 * Description: Add a git branch indicator to the toolbar.
 * Author: swaincreates
 * Author URI: https://github.com/swaincreates
 * Requires at least: 3.8
 * Tested up to: 3.8
 *
 * Text Domain: 
 * Domain Path:
 *
 */

if ( ! defined( 'ABSPATH' ) ) exit;

function show_git_branch( $wp_admin_bar ){
        
        //get_home_path requires following file.. may mess up if wp is in another directory?
        require_once( ABSPATH . 'wp-admin/includes/file.php' );

    	//get root path from WP dir
    	$root_path = get_home_path() . '.git/HEAD';
    	
    	//get root path from active WP Theme, even if child theme
    	$theme_path = get_stylesheet_directory() . '/.git/HEAD';
    	
    	
        //get branch name
    	if ( file_exists( $theme_path )) {
    		$stringfromfile = file( $theme_path );
    		$branchname = implode('/', array_slice( explode('/', file_get_contents($theme_path) ), 2) );
        } elseif ( file_exists( $root_path ) ) {
            $stringfromfile = file( $root_path );
            $branchname = implode('/', array_slice( explode('/', file_get_contents( $root_path) ), 2) );
    	} else {
    		$branchname	= "No git detected";
    	}

		
		$args = array(
							"id" => "show-git-branch",
							"title" => "$branchname"
						);
	$wp_admin_bar->add_node( $args );
}
add_action( 'admin_bar_menu', 'show_git_branch', 999 );

function dont_add_css_http_request(){
    echo '<style type="text/css">#wp-admin-bar-show-git-branch .ab-item:before {content: "\f237";top:2px;}</style>';
}
add_action( 'admin_head', 'dont_add_css_http_request' );
add_action( 'wp_head', 'dont_add_css_http_request' );

