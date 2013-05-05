<?php
/**
 * Super Interactive Automagic Widgets
 *
 * Allows you to programmatically add widgets to specified sidebars in WordPress.
 * 
 * 
 * @author Bastiaan van Dreunen <bastiaan@superinteractive.com>
 * 
 * http://www.superinteractive.com
 * 
 */

class SI_Automagic_Widgets {

	protected $sidebar_options = array();
	protected $widgets = array();

	/**
	 * Add widgets programmatically to the specified sidebars
	 * and using the specified arguments/properties
	 * 
	 * @param array $widgets An array of associative arrays in the format
	 * "sidebar" => "sidebar_id",
	 * "widget" => "widget_id",
	 * "args" => "widget_arguments"
	 */
	function add_widgets( $widgets ) {

		# Bounce if we have nothing to digest
		if( ! count( $widgets ) )
			return false;

		# Get current sidebars_widgets option value 
		$this->sidebar_options = get_option( "sidebars_widgets", array() );

		# Walk through widgets to get the current iterations
		$this->_count_widgets();

		foreach( $widgets as $widget ) {

			# Add the specified widget to the specified sidebar
			$this->_add_widget( $widget );
		}

		# Save the new sidebar/widget data
		$this->_save();
	}

	/**
	 * Private method to add a specified widget to a specified sidebar with the specified arguments
	 * 
	 * @param array $widget An associative array in the format
	 * "sidebar" => "sidebar_id",
	 * "widget" => "widget_id",
	 * "args" => "widget_arguments"
	 */
 	function _add_widget( $widget ) {

 		$sidebar_id = $widget["sidebar"];
 		$widget_id = $widget["widget"];
 		$widget_args = $widget["args"];

 		# Get the current widget list of the specified sidebar
		$sidebar = $this->sidebar_options[$sidebar_id];

		# Get the iteration of the specified widget and add 1 for ours
		$count = $this->widgets[$widget_id] + 1;

		# Add the widget to the specified sidebars widget list
		$sidebar[] = "$widget_id-$count";

		# Put the new widget list back in the global sidebar set
		$this->sidebar_options[$sidebar_id] = $sidebar;

		# Get the current widget contents option value for the specified widget type
		$widget_contents = get_option( "widget_$widget_id", array() );

		# Add the specified arguments as content for our widget
		$widget_contents[$count] = $widget_args;

		# Add the widget contents to the global widgets set
		$this->widgets[$widget_id] = $widget_contents;

 	}

 	/**
 	 * Get the current iterations of all widget types
 	 * 
 	 * @return void
 	 */
 	function _count_widgets() {

 		if( $this->sidebar_options ) {

 			# Exclude helpers
 			$exclude = array( "wp_inactive_widgets", "array_version" );

 			# Walk through all sidebars and widget sets
 			foreach( $this->sidebar_options as $sidebar_id => $sidebar_widgets ) {

 				# Check if sidebar is not in exclude list
 				if( ! in_array( $sidebar_id, $exclude ) ) {

 					# Walk through widgets
 					foreach( $sidebar_widgets as $widget ) {

 						# Get widget name and count
 						list($name, $count) = preg_split('/-+(?=\S+$)/', $widget);

 						# Set the current widget type count
 						if( !isset( $this->widgets[$name] ) || $count > $this->widgets[$name] ) {
 							$this->widgets[$name] = $count;
 						}
 					}
 				}
 			}
 		}
 	}

 	/**
 	 * Save updates after processing the sidebars and widgets
 	 * 
 	 * @return void
 	 */
 	function _save() {

 		# Save the new sidebars_widgets option value
		update_option( "sidebars_widgets", $this->sidebar_options );

		# Save each widget content settings
		if( count( $this->widgets ) ) {
			foreach( $this->widgets as $widget_id => $widget_contents ) {
				update_option( "widget_$widget_id", $widget_contents );
			}	
		}
 	}
}

?>