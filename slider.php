<?php
 /* Plugin Name:Post Slider
   * Description: Simple Plugin to display post slider
   * Plugin URI:http://pooja.tyche.work
   *  version:1.0
   * Author: Team Tyache Ventures
   * Author URI:http:/pooja.tyche.work
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

function slider_taxonomy(){
     
     $labels = array(
         
         'name' => _x('sliders','taxonomy general name','textdomain'),
         'singular_name' => _x('slider','taxonomy general name','textdomain'),
         'search_item' => __('Search slider'),
         'all_item' => __('All slider'),
         'parent_item' => __('Parent slider'),
         'parent_item_colon' => __('Parent slider:'),
         'edit_item' => __('Edit slider'),
         'update_item' => __('Update slider'),
         'add_new_item' =>__('Add new slider'),
         'new_item_name' => __('Add new slider  name'),
         'menu_name' => __('slider')
         
         
         );
         
         $args = array(
             
             'labels'=> $labels,
             'heirarchical'=> true,
             'show_admin_column'=>true,
             'show_ui'=> true,
             'show_in_menu'=>true,
             'show_in_nav_menus' => true,
             'rewrite'=> false,
             'queury_var'=> true,
             'public' => true,
             'show_in_rest'=>true
             
             
             );
             
        register_taxonomy('slider',array('post_slider'),$args);
 
 }
 
 add_action('init','slider_taxonomy');


//Add column

function add_post_img_column($columns){
    
    $new = array();
    foreach($columns as $key => $title){
        
        if($key == 'date'){
        
         $new['image']='Featured Image';
        
        }
        
        $new[$key] = $title;
    }
    
    return $new;
    
    
}

add_filter('manage_post_slider_posts_columns','add_post_img_column');

function load_media(){

	wp_enqueue_media();
}

add_action('admin_enqueue_scripts','load_media');

//Add Meta Box
add_action('add_meta_boxes','slider_custom_meta_box');
function slider_custom_meta_box(){
    
    add_meta_box('slider_meta_id','slider Meta Box','post_slider_meta_box','post_slider','advanced','default');
}
function slider_script(){
    
    wp_enqueue_script('post_slider_script',plugin_dir_url(__FILE__).'assets/js/slider.js');
    
}
add_action('wp_enqueue_scripts','slider_script',12);


function post_slider_meta_box($post){
	
	global $post;
	$upload_link = esc_url( get_upload_iframe_src( 'image', $post->ID ) );
	$img_id = get_post_meta( $post->ID, 'upload_image', true );
	$img_src = wp_get_attachment_image_src( $img_id, 'full' );
	$upload_img = is_array( $img_src );
	?>
	<div class="custom-img-container">
		<?php if ( $upload_img ) { ?>
			<img src="<?php echo $img_src ?>" alt="" style="max-width:100%;" />
		<?php } ?>
	</div>
	<p class="hide-if-no-js">
		<a  class="upload-custom-img <?php if ( $upload_img  ) { echo 'hidden'; } ?>" href="<?php echo $upload_link ?>"><?php _e('Set custom image') ?>
		</a>
		<a class="delete-custom-img <?php if(!$upload_img){ echo 'hidden';} ?>" href="#"><?php _e('Remove Image') ?></a>
	</p>
	<input class="custom-img-id" name="custom-img-id" type="hidden" value="<?php echo esc_attr( $img_id ); ?>" 
	
	
<?php
	
}

function post_slider_save_meta($post_id){
	update_post_meta($post_id,'upload_image',$_POST['upload_image']);
	
}

add_action('save_post','post_slider_save_meta');


function slider_options(){
	add_options_page('Post Slider Setting','slider setting','manage_options','slider_setting_slug','slider_option_page_func');	
}
add_action('admin_menu','slider_options');

function slider_options_setting_func(){
	
	add_settings_section('slider_setting_section_id1','slider setting section','slider_setting_section_func','slider_setting_slug');
	add_settings_field('slider_setting_id','slider setting','slider_setting_func','slider_setting_slug','slider_setting_section_id1');
	register_setting('slider_setting_slug','slider_setting_id');
	add_settings_section('slider_setting_section_id2','post type setting','post_type_setting_func','slider_setting_slug');
	add_settings_field('slider_setting_id2','post type','post_type_func','slider_setting_slug','slider_setting_section_id2');
	register_setting('slider_setting_slug','slider_setting_id2');
}
add_action('admin_init','slider_options_setting_func');

function slider_option_page_func(){
	?>
	<div class="wrap">
		<h2><?php _e('Post Slider Setting'); ?></h2>
		<form action = "options.php" method ="post">
		
			<?php settings_fields('slider_setting_slug'); ?>
			<?php do_settings_sections('slider_setting_slug'); ?>
			<?php submit_button(); ?>
			
		</form>
		
	</div>
	
	<?php
}



function slider_setting_section_func(){
	 
	 
}

function slider_setting_func(){
	

	echo '<input name="slider_setting_id" id="slider_setting_id" type="checkbox" value="enable" '.checked('enable',get_option('slider_setting_id'),false).'/>Enable slider setting';
	
}

function post_type_setting_func(){}


function post_type_func(){

	echo '<input name="slider_setting_id2" id="slider_setting_id2" type="checkbox" value="post" '.checked('post',get_option('slider_setting_id2'),false).'/>Post<br><br>';
	echo '<input name="slider_setting_id2" id="slider_setting_id2" type="checkbox" value="page" '.checked('page',get_option('slider_setting_id2'),false).'/>Page';
	
}


