<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package CWW_Portfolio
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function cww_portfolio_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'cww_portfolio_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function cww_portfolio_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'cww_portfolio_pingback_header' );




/**
* Strip whitespace in dynamic style
*/
if( !function_exists('cww_portfolio_strip_css_whitespace') ){
    function cww_portfolio_strip_css_whitespace($css){
        $replace = array(
        "#/\*.*?\*/#s" => "",  // Strip C style comments.
        "#\s\s+#"      => " ", // Strip excess whitespace.
        );
        $search = array_keys($replace);
        $css = preg_replace($search, $replace, $css);
        
        $replace = array(
        ": "  => ":",
        "; "  => ";",
        " {"  => "{",
        " }"  => "}",
        ", "  => ",",
        "{ "  => "{",
        ";}"  => "}", // Strip optional semicolons.
        ",\n" => ",", // Don't wrap multiple selectors.
        "\n}" => "}", // Don't wrap closing braces.
        //"} "  => "}\n", // Put each rule on it's own line.
        );
        $search = array_keys($replace);
        $css = str_replace($search, $replace, $css);
        
        return trim($css);
    }
}


if( ! function_exists( 'cww_portfolio_excerpt_content' ) ):
    function cww_portfolio_excerpt_content( $limit ) {

        $striped_contents   = strip_shortcodes( get_the_excerpt() );
        $striped_content    = strip_tags( $striped_contents );
        $limit_content      = mb_substr( $striped_content, 0 , $limit );
       
        return $limit_content;
    }
endif;



/**
* Display numeric pagination for blogs
*/
if( ! function_exists('cww_portfolio_numeric_posts_nav')){
    function cww_portfolio_numeric_posts_nav() {
     
        if( is_singular() )
            return;
     
        global $wp_query;
     
        /** Stop execution if there's only 1 page */
        if( $wp_query->max_num_pages <= 1 )
            return;
     
        $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
        $max   = intval( $wp_query->max_num_pages );
     
        /** Add current page to the array */
        if ( $paged >= 1 )
            $links[] = $paged;
     
        /** Add the pages around the current page to the array */
        if ( $paged >= 3 ) {
            $links[] = $paged - 1;
            $links[] = $paged - 2;
        }
     
        if ( ( $paged + 2 ) <= $max ) {
            $links[] = $paged + 2;
            $links[] = $paged + 1;
        }
     
        echo '<div class="add-archive-navigation">';
     
        /** Previous Post Link */
        if ( get_previous_posts_link() )
            printf( '<span class="prev">%s</span>' . "\n", get_previous_posts_link() );

        echo '<ul>';
        /** Link to first page, plus ellipses if necessary */
        if ( ! in_array( 1, $links ) ) {
            $class = 1 == $paged ? ' class="active"' : '';
     
            printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );
     
            if ( ! in_array( 2, $links ) )
                echo '<li>...</li>';
        }
     
        /** Link to current page, plus 2 pages in either direction if necessary */
        sort( $links );
        foreach ( (array) $links as $link ) {
            $class = $paged == $link ? ' class="active"' : '';
            printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
        }
     
        /** Link to last page, plus ellipses if necessary */
        if ( ! in_array( $max, $links ) ) {
            if ( ! in_array( $max - 1, $links ) )
                echo '<li>...</li>' . "\n";
     
            $class = $paged == $max ? ' class="active"' : '';
            printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
        }
        echo '</ul>';
        /** Next Post Link */
        if ( get_next_posts_link() )
            printf( '<span class="next">%s</span>' . "\n", get_next_posts_link() );
     
        echo '</div>' . "\n";
     
    }
}


 /**
   * Get all registered widget areas list
   * 
   */
/* Creating a function that will return an array of all the registered widget areas. */
if ( ! function_exists('cww_portfolio_get_widget_areas')):
    function cww_portfolio_get_widget_areas(){
        global $wp_registered_sidebars;
        $widgets_areas 		= array();
        $get_widget_areas 	= $wp_registered_sidebars;
        if ( ! empty( $get_widget_areas ) ) {
            foreach ( $get_widget_areas as $widget_area ) {
                $name 	= isset ( $widget_area['name'] ) ? $widget_area['name'] : '';
                $id 	= isset ( $widget_area['id'] ) ? $widget_area['id'] : '';
                if ( $name && $id ) {
                    $widgets_areas[$id] = $name;
                }
            }
        }
        return $widgets_areas;
    }
  endif;


  /**
   * Sidebar body class Controller function
   * 
   */
  add_filter( 'body_class', 'cww_portfolio_sidebar_body_class' );
  if( ! function_exists( 'cww_portfolio_sidebar_body_class' ) ):
    function cww_portfolio_sidebar_body_class($classes) {
        global $post;
        $defaults                   = cww_portfolio_customizer_defaults();
        $cww_portfolio_inner_single_sidebar 	= get_theme_mod( 'cww_portfolio_inner_single_sidebar', $defaults['cww_portfolio_inner_single_sidebar']);
        $cww_portfolio_inner_blog_sidebar    = get_theme_mod( 'cww_portfolio_inner_blog_sidebar', $defaults['cww_portfolio_inner_blog_sidebar']);


        if(!is_search() && is_singular()){
	
            
        $classes[] 	=  $cww_portfolio_inner_single_sidebar;   
            
        }
        if ( is_archive() || is_home()  || is_search() ) {
            $classes[] 	=  $cww_portfolio_inner_blog_sidebar;
        }

        return $classes;

    }
    endif;


    /**
* Retrieve post meta and default value of metabox
* @since 1.0.0
*/
function cww_portfolio_get_post_meta( $key, $defaults = '' ){
    global $post;
  
    if(! $post )
      return;
      
      $default = $defaults;
      $meta_val =  get_post_meta( $post->ID, $key , true ); 
  
      if( empty($meta_val) && ($defaults != '') ){
          $meta_val = $default;
      }
  
      return $meta_val;
  
  }
