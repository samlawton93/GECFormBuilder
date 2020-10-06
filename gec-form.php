<?php
/*
Plugin Name: GEC Form Generator
Plugin URI: https://codewithsam.co.uk
Description: Generates a shortcode to display the enquiry form on GEC
Version: 1.1
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
            add_shortcode( 'contactForm', array( $this, 'contactForm' ) );
        }

        public function enqueue_scripts() {
            wp_enqueue_style( 'gecform', plugins_url( '/public/css/style.css', __FILE__ ), array(), 0.1 );
            wp_deregister_script('jquery');
            wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js', array(), null, true);
            wp_enqueue_script( 'gecformscript', plugins_url( '/public/js/script.js', __FILE__ ), array('jquery'), 0.2, true );
        }

        public function form( $atts ) {
            global $post;

            $atts = shortcode_atts(
                array(
                    'method' => 'post',
                    'class'  => array(),
                ), $atts, 'gecform');

                // Instantiate the form class
                $form = new PHPFormBuilder();

                //Set form options
                $form->set_att( 'action', esc_url( '/' ) );
                $form->set_att( 'enctype', '');
                $form->set_att( 'add_honeypot', false );
                if (!empty($atts['class'])) {
                    $form->set_att( 'class', 'EnquiryForm ' . $atts['class'] );
                } else {
                    $form->set_att( 'class', 'EnquiryForm ' );
                }
                $form->set_att( 'id', 'enquiryForm' );

                //Set form fields
                $form->add_input( 'Name', array(
                    'type'     => 'text',
                    'class'    => 'form_field',
                ), 'enquiry_name');

                $form->add_input( 'Email', array(
                    'type'     => 'email',
                    'class'    => 'form_field',

                ), 'enquiry_email');

                $form->add_input( 'Telephone', array(
                    'type'       => 'tel',
                    'class'      => 'form_field',
                    'wrap_class' => 'form_field_wrap_multi'

                ), 'enquiry_telephone');

                $form->add_input( 'Postcode', array(
                    'type'       => 'text',
                    'class'      => 'form_field',
                    'wrap_class' => 'form_field_wrap_multi'
                ), 'enquiry_postcode');

                $form->add_input( 'Service Required', array(
                    'type'       => 'select',
                    'class'      => 'form_field',
                    'wrap_class' => 'form_field_wrap form_field_select',
                    'options'  => array(
                        ''                        => 'Please Select',
                        'Electricity Connections' => 'Electricity Connections',
                        'Gas Connections'         => 'Gas Connections',
                        'Water Connections'       => 'Water Connections',
                        'Multi Connections'       => 'Multi Connections',
                    ),
                ), 'enquiry_service');

                $form->add_input( 'Property Type', array(
                    'type'       => 'select',
                    'class'      => 'form_field',
                    'wrap_class' => 'form_field_wrap form_field_select',
                    'options'  => array(
                        ''                        => 'Please Select',
                        'Domestic/Home' => 'Domestic/Home',
                        'Business'         => 'Business',
                    ),
                ), 'enquiry_type');

                $form->add_input( false, array(
                    'type' => 'text',
    				'wrap_tag'         => 'div',
    				'wrap_class'       => array( 'form_field_wrap', 'hidden' ),
    				'wrap_id'          => '',
    				'wrap_style'       => 'display: none',
                ), 'enquiry_honeypot');

                // Shortcode should not output data directly
                ob_start();

                //Build the form
                $form->build_form();

                //Return and clean buffer content
                return ob_get_clean();
        }

        public function contactForm( $atts ) {
            global $post;

            $atts = shortcode_atts(
                array(
                    'method' => 'post',
                ), $atts, 'contactForm');

                // Instantiate the form class
                $form = new PHPFormBuilder();

                //Set form options
                $form->set_att( 'action', esc_url( '/' ) );
                $form->set_att( 'add_honeypot', false );
                $form->set_att( 'class', 'contactForm' );
                $form->set_att( 'id', 'contactForm' );

                //Set form fields
                $form->add_input( 'Name', array(
                    'type'     => 'text',
                    'class'    => 'form_field',
                ), 'contact_name');

                $form->add_input( 'Email', array(
                    'type'     => 'email',
                    'class'    => 'form_field',

                ), 'contact_email');

                $form->add_input( 'Telephone', array(
                    'type'       => 'tel',
                    'class'      => 'form_field',

                ), 'contact_phone');

                $form->add_input( 'Enquiry', array(
                    'type'       => 'text',
                    'class'      => 'form_field',
                ), 'contact_enquiry');

                $form->add_input( 'Your Message', array(
                    'type'       => 'textarea',
                    'class'      => 'form_field',
                    'wrap_class' => 'form_field_wrap_textarea'
                ), 'contact_message');

                $form->add_input( false, array(
                    'type' => 'text',
    				'wrap_tag'         => 'div',
    				'wrap_class'       => array( 'form_field_wrap', 'hidden' ),
    				'wrap_id'          => '',
    				'wrap_style'       => 'display: none',
                ), 'contact_honeypot');

                $form->add_input( false, array(
                    'type' => 'submit',
                    'wrap_class' => 'form-field',
                    'value' => 'Submit'
                ), 'contact_submit');

                // Shortcode should not output data directly
                ob_start();

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
