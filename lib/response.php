<?php

class BackboneResponse {
  
  function __construct( $type, $id, $number, $offset, $exclude, $slug ) {
    $this->id = $id;
    $this->type = $type;
    $this->number = $number;
    $this->offset = $offset;
    $this->exclude = $exclude;
    $this->set_response();
  }
  
  function set_response() {
    // Get a single post.
    if( $this->type == 'post' ) {
      $post = get_post( $this->id );
      $result = array();
      $cat = get_the_category( $post->ID );
      $result['category'] = $cat[0]->name;
      $result['category_id'] = $cat[0]->term_id;
      $result['category_slug'] = $cat[0]->slug;
      $result['post_id'] = $post->ID;
      $result['slug'] = $post->post_name;
      $result['content'] = apply_filters( 'the_content', $post->post_content );
      $result['thumbnail'] = get_the_post_thumbnail( $post->ID, 'thumbnail' );
      $result['image'] = get_the_post_thumbnail( $post->ID, 'full', array( 'class' => 'attachment' ) );
      $result['title'] = $post->post_title;
      $result['date'] = $post->post_date;
      $name = get_userdata( $post->post_author );
      $result['lastname'] = $name->user_lastname;
      $result['firstname'] = $name->user_firstname;
      $result['tags'] = wp_get_post_tags( $post->ID );
      $this->response = array( $result );

    // Get a group of posts.
    } elseif( $this->type == 'posts' ) {
      $options = array(
        'numberposts' => $this->number,
        'offset' => $this->offset,
        'exclude' => $this->exclude
      );
      $posts = get_posts( $options );
      $results = array();
      foreach( $posts as $post ) {
        $result = array();
        $cat = get_the_category( $post->ID );
        //echo var_dump( $cat );
        $result['category'] = $cat[0]->name;
        $result['category_id'] = $cat[0]->term_id;
        $result['category_slug'] = $cat[0]->slug;
        $result['post_id'] = $post->ID;
        $result['slug'] = $post->post_name;
        $result['content'] = apply_filters( 'the_content', $post->post_content );
        $result['thumbnail'] = get_the_post_thumbnail( $post->ID, 'thumbnail' );
        $result['image'] = get_the_post_thumbnail( $post->ID, 'full', array( 'class' => 'attachment' ) );
        $result['title'] = $post->post_title;
        $result['date'] = $post->post_date;
        $name = get_userdata( $post->post_author );
        $result['lastname'] = $name->user_lastname;
        $result['firstname'] = $name->user_firstname;
        $result['tags'] = wp_get_post_tags( $post->ID );
        array_push( $results, $result );
      }
      $this->response = $results;
    
    // Get a list of categories.
    } elseif( $this->type == 'categories' ) {
      $raw_cats = get_categories();
      $cats = array();
      foreach( $raw_cats as $k => $v ) {
        array_push( $cats, $v );
      }
      $this->response = $cats;
      
    // If the request sucks. 
    } else {
      $this->response = null;
    }
  }
  
  function get_response() {
    return $this->response;
  }
  
}

?>