<?php
 /* Plugin Name:Post Slider
    Description: Simple Plugin to display post slider
    Plugin URI:http:/pooja.tyche.work
    version:1.0
    Author: Team Tyache Ventures
    Author URI:http:/pooja.tyche.work
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

add_action('init','show_slider');
function show_slider(){
    
   $labels = array(
       
       'name'=>_x('Post Slider','Post Type General Name','ps-custom-post-type'),
       'singular_name'=>_x('Post Slider','Post Type General Name','ps-custom-post-type'),
       'menu_name'=>_x('Post slider','admin menu','ps-custom-post-type'),
       'name_admin_bar'=>_x('Post slider','add new on admin bar','ps-custom-post-type'),
       'add_new'=>__('Add Slider','ps-custom-post-type'),
       'add_new_item'=>__('Add New Slider','ps-custom-post-type'),
       'edit_item'=>__('Edit Slider','ps-custom-post-type'),
       'view_item'=>__('View Slider','ps-custom-post-type'),
       
       
       ); 
    
    $args = array(
        
        'labels'=>$labels,
        'description'=>__('Plugin to show post slider','ps-custom-post-type'),
        'public'=>true,
        'publicly queryable'=>true,
        'supports'=>array('title','thumbnail'),
        'show_ui'=>true,
        'show_in_menu'=>true,
        'menu_position'=>8,
        'menu_icon'=>'dashicons-slides',
        'can_export'=>true,
        'has_archive'=>true,
        'exclude_from_search'=>false,
        'query_var'=>true,
        'capability_type'=>'post',
        'rewrite'=>array('slug'=>'post slider'),
        'hierarchical'=>false,
        'show_in_admin_bar'=>true,
        'show_in_nav_menus'=>true,
        
        );
        
        register_post_type('post_slider',$args);
    
}
