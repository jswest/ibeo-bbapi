<?php
/*
Plugin Name: Backbone API
Plugin URL:
Description: A stripped-down, RESTful API for WordPress, based on the JSON API plugin
Version: 0.3.1
Author: John West
Author URI: http://oberliner.net/
*/

if( !class_exists( "BackboneAPI" ) ) {
  include_once dirname( __FILE__ ) . '/lib/query.php';
  include_once dirname( __FILE__ ) . '/lib/response.php';
  class BackboneAPI {
    function __construct() {
      $this->query = new BackboneAPIQuery();
    }
  }
}
if( class_exists( "BackboneAPI" ) ) {
  $bb_api = new BackboneAPI();
}
?>