<?php
/**
 * Example usage of the Automagic Widgets class.
 * 
 * This shows you how you can implement Automagic Widgets
 * 
 */

require( "SI_Automagic_Widgets.class.php" );

class My_Theme_Sidebars {

	function __construct() {
		
		# Add widgets automagically on theme activate
		add_action( "after_switch_theme", array( &$this, "register_widgets" ) );
	}

	function register_widgets( $theme_name ) {

		# Check if it is indeed our theme we're activating, and if we haven't
		# added the widgets before
		if ( 'My_Theme_Name' == get_current_theme() && false == get_option( "my_theme_automagic_widgets_added" ) ) {
		
			# Check if Automated Widgets class exists
			if( class_exists( "SI_Automagic_Widgets" ) ) {

				# Initiate the class
				$auto_widgets = new SI_Automagic_Widgets;

				# Add your widgets.
				# Note that you should to have these sidebars registered by now.
				$auto_widgets->add_widgets(
					array(
						# Add a text widget to my homepage sidebar
						array( 
							"sidebar" => "homepage_sidebar",
							"widget" => "text",
							"args" => array( "title" => "My text widget", "text" => "Lorem ipsum dolor sit amet." )
						),
						# Add a text widget to my blog sidebar
						array( 
							"sidebar" => "homepage_blog",
							"widget" => "search",
							"args" => array( "title" => "Search blog" )
						)
						# Etc...
					)
				);

				# Note this action for the future
				update_option( "my_theme_automagic_widgets_added", 1 );
			}
		}
	}
}

# Initiate the class
new My_Theme_Sidebars;

?>