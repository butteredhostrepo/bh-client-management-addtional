<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    Bh_Client_Management_Addtional
 * @subpackage Bh_Client_Management_Addtional/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Bh_Client_Management_Addtional
 * @subpackage Bh_Client_Management_Addtional/public
 * @author     Buttered Host <#>
 */
class Bh_Client_Management_Addtional_Public
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Bh_Client_Management_Addtional_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Bh_Client_Management_Addtional_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/bh-client-management-addtional-public.css', array(), $this->version, 'all');
		wp_enqueue_style('swipebox', plugin_dir_url(__FILE__) . 'swipebox/css/swipebox.css', array(), '', 'all');
		wp_enqueue_style('dropzone', plugin_dir_url(__FILE__) . 'dropzone/dropzone.css', array(), '', 'all');
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**+
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Bh_Client_Management_Addtional_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Bh_Client_Management_Addtional_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */


		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/bh-client-management-addtional-public.js', array('jquery'), $this->version, false);
		wp_enqueue_script('swipebox', plugin_dir_url(__FILE__) . '/swipebox/js/jquery.swipebox.js', array('jquery'), $this->version, false);
		wp_enqueue_script('dropzone', plugin_dir_url(__FILE__) . 'dropzone/dropzone.js', array('jquery'), $this->version, false);
		wp_enqueue_script('dzh4h', plugin_dir_url(__FILE__) . 'dropzone/dzh4h.js', array('jquery'), $this->version, false);
	}
}
