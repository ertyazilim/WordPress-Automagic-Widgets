Automagic Widgets in WordPress
==============================

Allows you to programmatically add widgets to specified sidebars in WordPress.

Sometimes, usually when you are building a WordPress theme, you want to be able to add a  
specified set of widgets in specified sidebars programmatically,
for instance to populate a certain sidebar of your theme automatically when it's activated.
This class allows you to do just that.

Please note that when you use this class, you still need to think about at what point the widgets
area added. You don't want to add widgets on each page load.

## Example usage
Check out example-usage.php to see how it can be implemented. In this example 2 widgets are added 
when a theme called My_Theme_Name is activated. 1 text widget to a sidebar called homepage_sidebar,
and 1 search widget to a sidebar called blog_sidebar.

Note that you can also use your own custom widgets by using their widget_id.