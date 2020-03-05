<?php
/*
Plugin Name: GEC Form Generator
Plugin URI: https://codewithsam.co.uk
Description: Generates a shortcode to display the enquiry form on GEC
Version: 1.0
Author: Sam Lawton
Author URI: https://codewithsam.co.uk
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: gec-forms
Domain Path: /languages
*/

require_once( __DIR__ .'/includes/class-PHPFormBuilder.php' );

// Main Plugin Class
if ( ! class_exists( 'GECForms' ) ) {
    class GECForms {
        public function __construct() {
            add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
            add_shortcode( 'gecform', array( $this, 'form' ) );
        }

        public function enqueue_scripts() {
            wp_enqueue_style( 'gecform', plugins_url( '/public/css/style.css', __FILE__ ), array(), 0.1 );
        }

        public function form( $atts ) {
            global $post;

            $atts = shortcode_atts(
                array(
                    'method' => 'post',
                ), $atts, 'gecform');

                // Instantiate the form class
                $form = new PHPFormBuilder();

                //Set form options
                $form->set_att( 'action', esc_url( '/' ) );
                $form->set_att( 'honeypot', true );
                $form->set_att( 'class', array('enquiryForm') );
                $form->set_att( 'id', 'enquiryForm' );

                //Set form fields
                $form->add_input( 'Name', array(
                    'type'     => 'text',
                    'class'    => 'form_field',
                    'required' => true,
                ), 'enquiry_name');

                $form->add_input( 'Email', array(
                    'type'     => 'email',
                    'class'    => 'form_field',
                    'required' => true,
                ), 'enquiry_email');

                $form->add_input( 'Property Type', array(
                    'type'     => 'select',
                    'class'    => 'form_field',
                    'options'  => array(
                        ''         => 'Please Select',
                        'home'     => 'Home',
                        'business' => 'Business',
                    ),
                    'required' => true,
                ), 'enquiry_property');

                $form->add_input( 'Website', array(
                    'type'     => 'url',
                    'class'    => 'form_field',
                    'required' => false,
                ), 'enquiry_website');

                $form->add_input( 'Message', array(
                    'type'     => 'textarea',
                    'class'    => 'form_field',
                    'required' => true,
                ), 'enquiry_message');

                // Shortcode should not output data directly
                ob_start();

                $status = filter_input( INPUT_GET, 'status', FILTER_VALIDATE_INT );

                if ($status = 1) {
                    printf( '<div class="message success"><p>%s</p></div>', __('Your message was submitted successfully.', 'gec-forms' ) );
                }

                //Build the form
                $form->build_form();

                //Return and clean buffer content
                return ob_get_clean();
        }

        public function form_handler() {

        }
    }
}

$gecforms = new GECForms;
