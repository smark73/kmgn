<?php

/*
Plugin Name: TuneGenie
Plugin URI: gcmaz.com
Description: Creates the TuneGenie Widget for sidebars
Version: 1.0
Author: Stacy Mark
Author URI: 
*/

// Creating the widget 
class tg_widget extends WP_Widget {

function __construct() {
    parent::__construct(
    // Base ID of your widget
    'tg_widget',

    // Widget name will appear in UI
    __('Tune Genie Widget', 'tg_widget_domain'),

    // Widget description
    array( 'description' => __( 'Embeds TuneGenie Widget', 'tg_widget_domain' ), )
    );
}

// Creating widget front-end
// This is where the action happens
public function widget( $args, $instance ) {
    $tg_link = apply_filters( 'widget_tg_link', $instance['tg_link'] );
    // before and after widget arguments are defined by themes
    echo $args['before_widget'];
    if ( ! empty( $tg_title ) )
        echo $args['before_title'] . $tg_title . $args['after_title'];

// This is where you run the code and display the output
print <<<EOM

<div class="centered music-ctr">
<iframe name="store" frameborder="0" marginheight="0" marginwidth="0" scrolling="no" src="$tg_link"></iframe>
</div>

EOM;

    echo $args['after_widget'];
}
		
// Widget Backend 
public function form( $instance ) {
    if ( isset( $instance[ 'tg_link' ] ) ) {
    $tg_link = $instance[ 'tg_link' ];
} else {
    $tg_link = __( 'TuneGenie', 'tg_widget_domain' );
}
// Widget admin form
?>
<p>TuneGenie Link:</p>
<p style="font-size:0.8em;"><?php echo esc_attr( $tg_link ); ?></p>
<p>
<label for="<?php echo $this->get_field_id( 'tg_link' ); ?>"><?php _e( 'Update TuneGenie Link:' ); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'tg_link' ); ?>" name="<?php echo $this->get_field_name( 'tg_link' ); ?>" type="text" value="<?php echo esc_attr( $tg_link ); ?>" />
</p>
<?php 
}
	
// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['tg_link'] = ( ! empty( $new_instance['tg_link'] ) ) ? strip_tags( $new_instance['tg_link'] ) : '';
    return $instance;
}
} // Class tg_widget ends here

// Register and load the widget
function tg_load_widget() {
	register_widget( 'tg_widget' );
}
add_action( 'widgets_init', 'tg_load_widget' );