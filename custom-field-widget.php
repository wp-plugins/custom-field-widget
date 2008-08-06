<?php
/*
PLUGIN NAME: Custom Field Widget
PLUGIN URI: http://www.plaintxt.org/experiments/custom-field-widget/
DESCRIPTION: Displays the values of specified <a href="http://codex.wordpress.org/Using_Custom_Fields">custom field</a> keys, allowing post- and page-specific meta content in your sidebar. A plaintxt.org experiment for WordPress.
AUTHOR: Scott Allan Wallick
AUTHOR URI: http://scottwallick.com/
VERSION: 0.1 &beta;
*/

/*
CUSTOM FIELD WIDGET
by SCOTT ALLAN WALLICK, http://scottwallick.com/
from PLAINTXT.ORG, http://www.plaintxt.org/

CUSTOM FIELD WIDGET is free software: you can redistribute it and/or
modify it under the terms of the GNU General Public License as
published by the Free Software Foundation, either version 3 of
the License, or (at your option) any later version.

CUSTOM FIELD WIDGET is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty
of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
See the GNU General Public License for details.

You should have received a copy of the GNU General Public License
along with CUSTOM FIELD WIDGET. If not, see www.gnu.org/licenses/.
*/

// Function for the Custom Field Widget
function wp_widget_custom_field( $args, $widget_args = 1 ) {
	// Let's begin our widget.
	extract( $args, EXTR_SKIP );
	// Our widgets are stored with a numeric ID, process them as such
	if ( is_numeric($widget_args) )
		$widget_args = array( 'number' => $widget_args );
	// We'll need to get our widget data by offsetting for the default widget
	$widget_args = wp_parse_args( $widget_args, array( 'number' => -1 ) );
	// Offset for this widget
	extract( $widget_args, EXTR_SKIP );
	// We'll get the options and then specific options for our widget further below
	$options = get_option('widget_custom_field');
	// If we don't have the widget by its ID, then what are we doing?
	if ( !isset($options[$number]) )
		return;
	// We'll use the standard filters from widgets.php for consistency
	$ckey  = $options[$number]['key'];
	$title = apply_filters( 'widget_title', $options[$number]['title'] );
	$text  = apply_filters( 'widget_text', $options[$number]['text'] );
	// Let's set a global to retrieve the post ID
	global $post;
	// Find a matching custom field value for our key
	$cvalue = get_post_meta( $post->ID, $ckey, true );
	// Do we have a matchin custom field value, i.e., does the post/page have a matching custom field key?
	if ( !empty($cvalue) ) {
		// Yes? Then let's make a widget. Open it.
		echo $before_widget;
		// Our widget title field is optional; if we have some, show it
		if ( $title ) {
			echo "\n$before_title $title $after_title";
		}
		// Our widget text field is optional; if we have some, show it
		if ( $text ) {
			echo "\n<div class='textwidget'>\n$text\n</div>\n";
		}
		// Let's apply our filters to the custom field value
		$cvalue = apply_filters( 'custom_field_value', $cvalue );
		// Echo the matching custom field value, filtered nicely
		echo "\n<div class='customvalue'>\n$cvalue\n</div>\n";
		// Close our widget.
		echo $after_widget;
	}
	// And we're finished with the actual widget
}
// Function for the Custom Field Widget options panels
function wp_widget_custom_field_control($widget_args) {
	// Establishes what widgets are registered, i.e., in use
	global $wp_registered_widgets;
	// We shouldn't update, i.e., process $_POST, if we haven't updated
	static $updated = false;
	// Our widgets are stored with a numeric ID, process them as such
	if ( is_numeric($widget_args) )
		$widget_args = array( 'number' => $widget_args );
	// We can process the data by numeric ID, offsetting for the '1' default
	$widget_args = wp_parse_args( $widget_args, array( 'number' => -1 ) );
	// Complete the offset with the widget data
	extract( $widget_args, EXTR_SKIP );
	// Get our widget options from the databse
	$options = get_option('widget_custom_field');
	// If our array isn't empty, process the options as an array
	if ( !is_array($options) )
		$options = array();
	// If we haven't updated (a global variable) and there's no $_POST data, no need to run this
	if ( !$updated && !empty($_POST['sidebar']) ) {
		// If this is $_POST data submitted for a sidebar
		$sidebar = (string) $_POST['sidebar'];
		// Let's konw which sidebar we're dealing with so we know if that sidebar has our widget
		$sidebars_widgets = wp_get_sidebars_widgets();
		// Now we'll find its contents
		if ( isset($sidebars_widgets[$sidebar]) ) {
			$this_sidebar =& $sidebars_widgets[$sidebar];
		} else {
			$this_sidebar = array();
		}
		// We must store each widget by ID in the sidebar where it was saved
		foreach ( $this_sidebar as $_widget_id ) {
			// Process options only if from a Widgets submenu $_POST
			if ( 'wp_widget_custom_field' == $wp_registered_widgets[$_widget_id]['callback'] && isset($wp_registered_widgets[$_widget_id]['params'][0]['number']) ) {
				// Set the array for the widget ID/options
				$widget_number = $wp_registered_widgets[$_widget_id]['params'][0]['number'];
				// If we have submitted empty data, don't store it in an array.
				if ( !in_array( "custom-field-$widget_number", $_POST['widget-id'] ) )
					unset($options[$widget_number]);
			}
		}
		// If we are returning data via $_POST for updated widget options, save for each widget by widget ID
		foreach ( (array) $_POST['widget-custom-field'] as $widget_number => $widget_custom_field ) {
			// If the $_POST data has values for our widget, we'll save them
			if ( !isset($widget_custom_field['key']) && isset($options[$widget_number]) )
				continue;
			// Create variables from $_POST data to save as array below
			$key   = strip_tags(stripslashes($widget_custom_field['key']));
			$title = strip_tags(stripslashes($widget_custom_field['title']));
			// For the optional text, let's carefully process submitted data
			if ( current_user_can('unfiltered_html') ) {
				$text = stripslashes($widget_custom_field['text']);
			} else {
				$text = stripslashes(wp_filter_post_kses($widget_custom_field['text']));
			}
			// We're saving as an array, so save the options as such
			$options[$widget_number] = compact( 'key', 'title', 'text' );
		}
		// Update our options in the database
		update_option( 'widget_custom_field', $options );
		// Now we have updated, let's set the variable to show the 'Saved' message
		$updated = true;
	}
	// Variables to return options in widget menu below; first, if
	if ( -1 == $number ) {
		$key    = '';
		$title  = '';
		$text   = '';
		$number = '%i%';
	// Otherwise, this widget has stored options to return
	} else {
		$key    = attribute_escape($options[$number]['key']);
		$title  = attribute_escape($options[$number]['title']);
		$text   = format_to_edit($options[$number]['text']);
	}
	// Our actual widget options panel
?>
	<p><?php printf( __( 'Enter the custom field key <a href="%s">[?]</a>  to locate in single posts/pages. When found, the corresponding value is displayed along with widget title and text (if provided).', 'cf_widget' ), 'http://codex.wordpress.org/Using_Custom_Fields' ) ?></p>
	<p>
		<label for="custom-field-key-<?php echo $number; ?>"><?php _e( 'Custom Field Key (required):', 'cf_widget' ) ?></label>
		<input id="custom-field-key-<?php echo $number; ?>" name="widget-custom-field[<?php echo $number; ?>][key]" class="code widefat" type="text" value="<?php echo $key; ?>" /><br />
		<?php _e( 'The <strong>key</strong> must match <em>exactly</em> as in posts/pages.', 'cf_widget' ) ?>
	</p>
	<p>
		<label for="custom-field-title-<?php echo $number; ?>"><?php _e( 'Widget Title (optional):', 'cf_widget' ) ?></label>
		<input id="custom-field-title-<?php echo $number; ?>" name="widget-custom-field[<?php echo $number; ?>][title]" class="widefat" type="text" value="<?php echo $title; ?>" />
	</p>
	<p>
		<label for="custom-field-text-<?php echo $number; ?>"><?php _e( 'Widget Text (optional):', 'cf_widget' ) ?></label>
		<textarea id="custom-field-text-<?php echo $number; ?>" name="widget-custom-field[<?php echo $number; ?>][text]" class="widefat" rows="5" cols="20"><?php echo $text; ?></textarea>
		<input type="hidden" name="widget-custom-field[<?php echo $number; ?>][submit]" value="1" />
	</p>
<?php
	// And we're finished with our widget options panel
}
// Function to add widget option table when activating this plugin
function wp_widget_custom_field_activation() {
	add_option( 'widget_custom_field', '', '', 'yes' );
}
// Function to delete widget option table when deactivating this plugin
function wp_widget_custom_field_deactivation() {
	delete_option('widget_custom_field');
}
// Function to initialize the Custom Field Widget: the widget and widget options panel
function wp_widget_custom_field_register() {
	// Do we have options? If so, get info as array
	if ( !$options = get_option('widget_custom_field') )
		$options = array();
	// Variables for our widget
	$widget_ops = array(
			'classname'   => 'widget_custom_field',
			'description' => __( 'Display page/post custom field value for a set key', 'cf_widget' )
		);
	// Variables for our widget options panel
	$control_ops = array(
			'width'   => 375,
			'height'  => 400,
			'id_base' => 'custom-field'
		);
	// Variable for out widget name
	$name = __( 'Custom Field', 'cf_widget' );
	// Assume we have no widgets in play.
	$id = false;
	// Since we're dealing with multiple widgets, we much register each accordingly
	foreach ( array_keys($options) as $o ) {
		// Per Automattic: "Old widgets can have null values for some reason"
		if ( !isset($options[$o]['title']) || !isset($options[$o]['text']) )
			continue;
		// Automattic told me not to translate an ID. Ever.
		$id = "custom-field-$o"; // "Never never never translate an id" See?
		// Register the widget and then the widget options menu
		wp_register_sidebar_widget( $id, $name, 'wp_widget_custom_field', $widget_ops, array( 'number' => $o ) );
		wp_register_widget_control( $id, $name, 'wp_widget_custom_field_control', $control_ops, array( 'number' => $o ) );
	}
	// Create a generic widget if none are in use
	if ( !$id ) {
		// Register the widget and then the widget options menu
		wp_register_sidebar_widget( 'custom-field-1', $name, 'wp_widget_custom_field', $widget_ops, array( 'number' => -1 ) );
		wp_register_widget_control( 'custom-field-1', $name, 'wp_widget_custom_field_control', $control_ops, array( 'number' => -1 ) );
	}
}
// Adds filters to custom field values to prettify like other content
add_filter( 'custom_field_value', 'convert_chars' );
add_filter( 'custom_field_value', 'stripslashes' );
add_filter( 'custom_field_value', 'wptexturize' );
// When activating/deactivating, run the appropriate function
register_activation_hook( __FILE__, 'wp_widget_custom_field_activation' );
register_deactivation_hook( __FILE__, 'wp_widget_custom_field_deactivation' );
// Allow localization, if applicable
load_plugin_textdomain('cf_widget');
// Initializes the function to make our widget(s) available
add_action( 'init', 'wp_widget_custom_field_register' );
// Fin.
?>