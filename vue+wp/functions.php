<?php
 
use Carbon_Fields\Container;
use Carbon_Fields\Field;

function my_scripts(){
wp_enqueue_script('jquery-js', 'https://code.jquery.com/jquery-3.3.1.min.js', array(), false, true);
wp_enqueue_script('vue-js', 'https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js', array(), false, true);
wp_enqueue_script('main-js', get_template_directory_uri() . '/js/main.js', array(), false, true);
}
add_action('wp_enqueue_scripts', 'my_scripts');


add_action( 'carbon_fields_register_fields', 'green_uv_mainpage_fields' );
function green_uv_mainpage_fields() {
    Container::make( 'post_meta', 'Main page fields' )
      ->where( 'post_type', '=', 'page' )
      //->show_on_template('templates/breaf.php')
	    //->where( 'post_template', '=', 'home_page' )
        	->add_tab( __('Banner'), array(
              Field::make( 'complex', 'green_uv_repet_welcome_image', 'Icons' )->set_visible_in_rest_api(  true )
                ->set_layout( 'tabbed-horizontal' )
                ->add_fields( 'text', 'Text field', array(
                  Field::make( 'text', 'name', 'Text' )->set_width( 50 ),
                 
                  ) )
                ->add_fields( 'radio', 'Radio field', array(
                  Field::make( 'text', 'name', 'Option' )->set_width( 33 ),
                  Field::make( 'text', 'placeholder', 'Placeholder' )->set_width( 33 ),
                  Field::make( 'complex', 'option', 'Option name' )
                    ->set_layout( 'tabbed-horizontal' )
                    ->add_fields( 'opt', 'Option name', array(
                      Field::make( 'text', 'oneoption', 'Option name' )->set_width( 33 ),
                    ))
                 
                  ) )
                ->add_fields( 'file', 'File field', array(
                  Field::make( 'text', 'name', 'File' )->set_width( 50 ),

                  ) ),       		
            	
            ));
       
}

add_action('wp_ajax_send_message', 'send_message');

add_action('wp_ajax_nopriv_send_message', 'send_message');

function send_message(){
  print_r($_POST);
  print_r($_FILES);
  die();
}

