=== Find Function/Class ===
Contributors: mte90
Donate link: http://mte90.net/
Tags: development, find, debug
Requires at least: 3.9
Tested up to: 4.2
Stable tag: 1.0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Search the file and row (on WordPress) that contain a PHP function or class with a click!

== Description ==

You don't find the PHP function or class in a Wordpress system?  
This plugin add a button on the admin bar that open a simple modal!

Check the screenshots!

GitHub: [https://github.com/Mte90/WP-Find-Function](https://github.com/Mte90/WP-Find-Function)

The plugin use `ReflectionFunction` and `ReflectionClass` of PHP5 to find this info.  

== Installation ==

1. Navigate to the 'Add New' in the plugins dashboard
2. Search for 'find-function'
3. Click 'Install Now'
4. Activate the plugin on the Plugin dashboard

== Frequently Asked Questions ==

= Why use? =

This solution is useful for not search in all of your files.  

= How work =

Simple ajax request in the same page that inject the data and show it in the modal.

== Screenshots ==

1. Class found
2. Function found
3. Function/Class not found

== Changelog ==

= 1.0.1 =
Support for enter key on the search field  
Text field escaped  
Show the parameters and the method if avalaible
= 1.0 =
First Release
