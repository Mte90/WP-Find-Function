<?php

/*
  Plugin Name: Find Function or Class
  Plugin URI: http://mte90.net
  Description: Found the function or class on the page (file and row inline) that you are visiting
  Version: 1.0.1
  Author: Mte90
  Author URI: http://mte90.net
  License: GPLv2 or later
 */

// Exit if accessed directly.
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Find Function class
 *
 * @since 1.0.0
 *
 * @package Find_Function
 * @author  Mte90
 */
class Find_Function {

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Constructor for the class.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		// Load our custom assets.
		add_action( 'admin_enqueue_scripts', array( $this, 'js' ) );
		// Hook into the 'wp_before_admin_bar_render' action
		add_action( 'wp_before_admin_bar_render', array( $this, 'find_function_menu' ), 999 );
		//Add the modal content
		add_action( 'wp_footer', array( $this, 'add_modal_content' ) );
		add_action( 'admin_footer', array( $this, 'add_modal_content' ) );
		//Inject the info about the file and the row
		if ( isset( $_GET[ 'ffsearch' ] ) && $_GET[ 'ffsearch' ] === 'search_the_function' && !empty( $_GET[ 'function' ] ) ) {
			add_action( 'wp_footer', array( $this, 'search_the_function' ) );
			add_action( 'admin_footer', array( $this, 'search_the_function' ) );
		}
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {
		if ( current_user_can( 'manage_options' ) ) {
			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self;
			}
		}
		return self::$instance;
	}

	/**
	 * RInject the js file and thickbox
	 *
	 * @since     1.0.0
	 *
	 */
	public function js() {
		add_thickbox();
		wp_register_script( 'find-function', plugins_url( '/js/modal.js', __FILE__ ), array( 'jquery' ), '1.0.0', true );
		wp_enqueue_script( 'find-function' );
	}

	/**
	 * Insert the menu in the admin bar
	 *
	 * @since     1.0.0
	 *
	 */
	public function find_function_menu() {
		global $wp_admin_bar;
		$args = array(
			'id' => 'find_function_item',
			'title' => 'Find Function/Class',
			'href' => '#TB_inline?width=600&height=550&inlineId=find-function-section',
			'group' => false,
			'meta' => array( 'class' => 'findfunction-menu' )
		);
		$wp_admin_bar->add_menu( $args );
	}

	/**
	 * Insert the modal
	 *
	 * @since     1.0.0
	 *
	 */
	public function add_modal_content() {
		echo '<div id="find-function-section" style="display:none;">
				<p style="text-align:center;">
					<label for="findfunction-inputdesc">Insert the function/class ( without <i>()</i> ):</label>
					<input type="text" id="findfunction-input">
					<input type="button" class="button button-primary" value="' . __( 'Send' ) . '" id="findfunction-button">
		        </p> 
				<p style="margin-bottom:0;">
					Results:
				</p>
				<p id="find-function-found" style="margin-top:-5px;">
				</p>
		</div>';
	}

	/**
	 * The div that conatin the info about the function/class
	 *
	 * @since     1.0.0
	 *
	 */
	public function search_the_function() {
		echo '<div id="find-function-result">';
		//The function exist?
		try {
			$reflFunc = new ReflectionFunction( esc_html( $_GET[ 'function' ] ) );
			echo 'File that contain Function <b>' . esc_html( $_GET[ 'function' ] ) . '</b>: <i>' . $reflFunc->getFileName() . '</i>';
			echo '<br>';
			echo 'Row: <b>' . $reflFunc->getStartLine() . '</b>';
			$temp = $reflFunc->getParameters();
			if ( !empty( $temp ) ) {
				foreach ( $temp as $param ) {
					echo '<br>' . $param;
				}
			}
		} catch ( Exception $e ) {
			echo '<p><b>Function <i>' . esc_html( $_GET[ 'function' ] ) . '</i> not found :-(</b><p>';
		}
		//The class exist?
		try {
			$reflClass = new ReflectionClass( esc_html( $_GET[ 'function' ] ) );
			echo 'File that contain Class <b>' . esc_html( $_GET[ 'function' ] ) . '</b>: <i>' . $reflClass->getFileName() . '</i>';
			echo '<br>';
			echo 'Row: <b>' . $reflClass->getStartLine() . '</b>';
			$temp = $reflClass->getConstructor()->getParameters();
			if ( !empty( $temp ) ) {
				foreach ( $temp as $param ) {
					echo '<br>' . $param;
				}
			}
			$temp = $reflClass->getMethods();
			if ( !empty( $temp ) ) {
				echo '<br>Methods:<br>';
				foreach ( $temp as $param ) {
					echo '&nbsp;&nbsp;' . $param->name . '<br>';
				}
			}
		} catch ( Exception $e ) {
			echo '<p><b>Class <i>' . esc_html( $_GET[ 'function' ] ) . '</i> not found :-(</b></p>';
		}
		echo '</div>';
	}

}

//Load the plugin
add_action( 'plugins_loaded', array( 'Find_Function', 'get_instance' ) );
