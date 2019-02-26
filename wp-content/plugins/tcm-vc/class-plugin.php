<?php
/**
Plugin Name: TCM modules for Visual Composer
Description: Add modules for Visual Composer
Author: The Creative Momentum
Version: 1.0
Author URI: https://www.thecreativemomentum.com/
Domain Path: /languages
 *
 * The main plugin file
 *
 * @package TCM Modules for Visual Composer
 */

if ( ! defined( 'ABSPATH' ) ) { exit; // Exit if accessed directly.
}

// Identifies the current plugin version.
defined( 'VERSION_TCM_VC' ) or define( 'VERSION_TCM_VC', 1.0 );
// The slug used for translations & other identifiers.
defined( 'TCM_VC' ) or define( 'TCM_VC', 'tcm-modules' );

//Functions
require_once( 'inc/plugin-functions.php' );

// This is the main plugin functionality.


//Hero
require_once( 'class/class-hero-text-green.php' );
require_once( 'class/class-hero-text-blue.php' );
require_once( 'class/class-hero-text-purple.php' );
require_once( 'class/class-hero-small.php' );

//Elements
require_once( 'class/class-three-column-content.php' );
require_once( 'class/class-four-column-content.php' );
require_once( 'class/class-resources.php' );
require_once( 'class/class-people-tiles.php' );
require_once( 'class/class-left-content-right-image.php' );
require_once( 'class/class-left-image-right-content.php' );
require_once( 'class/class-location.php' );
require_once( 'class/class-content-stats.php' );
require_once( 'class/class-testimonials.php' );
require_once( 'class/class-video.php' );
require_once( 'class/class-cards.php' );
require_once( 'class/class-icon-text.php' );
require_once( 'class/class-event-promo.php' );
require_once( 'class/class-logo-bar.php' );
require_once( 'class/class-gradient-cta.php' );
require_once( 'class/class-story.php' );
require_once( 'class/class-case-study.php' );
