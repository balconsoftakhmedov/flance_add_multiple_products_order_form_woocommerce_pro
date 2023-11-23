<?php
class Flance_Add_Multiple_Products_order_form_Woocommerce_Widget_Pro extends WP_Widget {
     
    public function __construct() {
	    parent::__construct(
	        // base ID of the widget
	        'flance_add_multiple_products_widget',
	        // name of the widget
	        __( 'Flance Add Multiple Products order form for Woocommerce', 'woomultiorderpro'),
	        // widget options
	        array (
				'classname' 	=>	'flance-amp-widget',
	            'description' => __( 'Flance Add Multiple Products order form for Woocommerce Widget.', 'woomultiorderpro')
	        )
	    );
    }
     
    public function form( $instance ) {
		$instance = wp_parse_args( (array)$instance, array(
				'flance-amp-title' 		=>	''
			) );
		include( plugin_dir_path( __FILE__ ).'partials/html-admin-view.php');
    }
     
    public function update( $new_instance, $old_instance ) {
		$old_instance['flance-amp-title'] = strip_tags( stripslashes( $new_instance['flance-amp-title'] ) );
		return $old_instance;
    }
     
    public function widget( $args, $instance ) {
		extract( $args );
		$title = $instance['flance-amp-title'];
        if ( get_option( 'flance_amp_user_check' ) == 1 && is_user_logged_in() ) {
        	$flance_user_role = get_option( 'flance_amp_user_role' );
            $flance_current_user_roles = Flance_Add_Multiple_Products_order_form_Woocommerce_Public_Pro::flance_amp_get_user_role( get_current_user_id() );
            $is_auth = array_intersect( $flance_user_role, $flance_current_user_roles )  ? 'true' : 'false';
			if ( !empty( $flance_user_role ) ) {
                if( $is_auth ){
		            if( !is_cart() ){
						echo $args['before_widget'];
		            	include 'partials/html-public-view.php';
						echo  $args['after_widget'];
		            }
		        }
		    } else {
	            if( !is_cart() ){
					echo $args['before_widget'];
	            	include 'partials/html-public-view.php';
					echo  $args['after_widget'];
	            }
		    }
        } else {
        	if ( !is_cart() ) {
				echo $args['before_widget'];
            	include 'partials/html-public-view.php';
				echo  $args['after_widget'];
        	}
        }
    }    
}