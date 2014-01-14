<?php

class BackboneResponse {
  
  function __construct( $type, $lookup_type, $id, $number, $offset, $exclude, $slug ) {
    $this->id = $id;
    $this->type = $type;
    $this->lookup_type = $lookup_type;
    $this->number = $number;
    $this->offset = $offset;
    $this->exclude = $exclude;
    $this->set_response();
  }

  function get_post_data( $post ) {
    $result = array();
    $cat = get_the_category( $post->ID );
    $result['category'] = $cat[0]->name;
    $result['category_id'] = $cat[0]->term_id;
    $result['category_slug'] = $cat[0]->slug;
    $result['tags'] = get_the_tags( $post->ID );
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
    return $result;
  }
  
  function set_response() {
    // Get a single post.
    if( $this->type == 'post' ) {
      $post = get_post( $this->id );
      $result = $this->get_post_data( $post );
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
        $result = $this->get_post_data( $post );
        array_push( $results, $result );
      }
      $this->response = $results;
    
    // Get a group of posts by category.
    } elseif( $this->type == 'category' ) {
      $options = array(
        'numberposts' => $this->number,
        'offset' => $this->offset,
        'exclude' => $this->exclude,
        'category' => $this->id
      );
      $posts = get_posts( $options );
      $results = array();
      foreach( $posts as $post ) {
        $result = $this->get_post_data( $post );
        array_push( $results, $result );
      }
      $this->response = $results;

    // Get a group of posts by tag.
    } elseif( $this->type == 'tag' ) {
      $options = array(
        'numberposts' => $this->number,
        'offset' => $this->offset,
        'exclude' => $this->exclude,
        'tag_id' => $this->id
      );
      $posts = get_posts( $options );
      $results = array();
      foreach( $posts as $post ) {
        $result = $this->get_post_data( $post );
        array_push( $results, $result );
      }
      $this->response = $results;

    // Get a list of categories.
    } elseif( $this->type == 'categories' ) {
      $cats = get_categories(
        array(
          'orderby' => 'count',
          'order' => 'DESC'
        )
      );
      $this->response = $cats;

    // Get a list of dates.
    } elseif( $this->type == 'dates' ) {
      $options = array(
        'echo' => false,
        'format' => ''
      );
      $dates = wp_get_archives( $options );
      $this->response = $dates;

    } elseif( $this->type == 'lookup' ) {
      $value = $this->id;
      if ( $this->lookup_type == 'tag' ) {
        $type = 'post_tag';
      } else {
        $type = $this->lookup_type;
      }
      $field = "id";
      $this->response = get_term_by( $field, $value, $type );

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