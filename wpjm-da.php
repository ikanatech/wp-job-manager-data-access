<?php
/**
 * @package WPJM Data Access
 * @version 0.0.1
*/
/*
Plugin Name: WPJM Data Access
Plugin URI: http://hektechnologies.com/plugins/wpjmda
Description: Plugin to free jobs data
Author: Spencer Heckathorn (borrowed the start from Astoundify)
Version: 0.0.1
Author URI: http://spencerheckathorn.com/
*/

add_filter( 'job_manager_output_jobs_defaults', array( $this, 'job_manager_output_jobs_defaults' ) );
function job_manager_output_jobs_defaults( $default ) {
        $type = get_queried_object();

        if ( is_tax( 'job_listing_type' ) ) {
                $default[ 'job_types' ] = $type->slug;
                $default[ 'selected_job_types' ] = $type->slug;
                $default[ 'show_categories' ] = true;

        }
        elseif ( is_tax( 'job_listing_category' ) ) {
                $default[ 'show_categories' ] = true;
                $default[ 'categories' ] = $type->slug;
                $default[ 'selected_category' ] = $type->slug;
        }
        elseif ( is_search() ) {
                $default[ 'keywords' ] = get_search_query();
                $default[ 'show_filters' ] = false;
        }

        if ( is_home() || is_page_template( 'page-templates/test.php' ) ) {
                $default[ 'show_category_multiselect' ] = false;
        }

        if ( isset( $_GET[ 'search_categories' ] ) ) {
                $category = get_term_by( 'ID', absint( $_GET[ 'search_categories' ] ), 'job_listing_category' );
                $default[ 'show_categories' ] = true;
                $default[ 'categories' ] = $_GET[ 'search_categories' ];
        }

      return $default;
}
