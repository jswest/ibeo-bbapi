<?php

class BackboneAPIQuery {
  
  function __construct() {
    add_action( 'template_redirect', array( $this, 'template_redirect' ) );
  }
  
  function template_redirect() {
    if( $this->is_bb() ) {
      $type = ( isset( $_REQUEST['type'] ) ? $_REQUEST['type'] : null );
      $id = ( isset( $_REQUEST['id'] ) ? $_REQUEST['id'] : null );
      $number = ( isset( $_REQUEST['number'] ) ? $_REQUEST['number'] : null );
      $offset = ( isset( $_REQUEST['offset'] ) ? $_REQUEST['offset'] : null );
      $exclude = ( isset( $_REQUEST['exclude'] ) ? $_REQUEST['exclude'] : null );
      $slug = ( isset( $_REQUEST['slug'] ) ? $_REQUEST['slug'] : null );
      $responder = new BackboneResponse( $type, $id, $number, $offset, $exclude, $slug );
      $response = $responder->get_response();
      header( "Content-Type: application/json" );
      echo json_encode( $response );
      exit;
    } else {
      return;
    }
  }
  
  // Determine if it's a backbone request or a regular request
  function is_bb() {
    if( isset($_REQUEST['bb'] ) ) {
      return true;
    } else {
      return false;
    }
  }
  
}
?>