<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://oddmotion.com
 * @since      1.0.0
 *
 * @package    Primary_Cat_Select
 * @subpackage Primary_Cat_Select/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Primary_Cat_Select
 * @subpackage Primary_Cat_Select/admin
 * @author     Chris Toomajanian <chris@oddmotion.com>
 */
class Primary_Cat_Select_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	public function primary_cat_meta() {
		// Here we're going to hook into WP so we can Add a new meta box and save the user selection after update
		add_action( 'add_meta_boxes', array( $this, 'primary_cat_meta_box') );
		add_action( 'save_post', array( $this, 'primary_cat_data' ) );
		add_shortcode( 'primary-category', array( $this, 'primary_cat_sc' ) );
	}

	public function primary_cat_meta_box() {
		// We want this primary category functionality to work across all post types
		$all_post_types = get_post_types();

		foreach ($all_post_types as $all_post_type ) {
			//  Let's add our meta box for selecting a Primary Category
			add_meta_box (
				'primary_cat',
				'Primary Category',
				array( $this, 'primary_cat_meta_inside' ),
				$all_post_type,
				'side',
				'core'
			);
		}
	}

	public function primary_cat_meta_inside() {
		// Here we will fill the select dropdown with a list from the current selected post categories
		global $post;

		$primary_cat = '';
		$cat_selected = get_post_meta( $post->ID, 'primary_cat', true );

		if ( $cat_selected != '' ) {
			$primary_cat = $cat_selected;
		}
		// Retrieve our available post categories
		$post_cats = get_the_category(); 

		echo '<div class="cat-descript"><p>Choose categories from the checklist above for this post, and click update.  When the page refreshes, you may choose one category from the list to be your Primary Category</p></div>';

		$html = '<select name="primary_cat" id="primary_cat">';
		// List each as on it's own line in the select dropdown
		foreach( $post_cats as $category ) {
			$html .= '<option value="' . $category->name . '" ' . selected( $primary_cat, $category->name, false) . '>' . $category->name . '</option>';
		}

		$html .= '</select>';

		echo $html;
	}

	public function primary_cat_data() {

		global $post;

		if ( isset( $_POST[ 'primary_cat' ] ) ) {
			$primary_cat = sanitize_text_field( $_POST[ 'primary_cat' ] );

			update_post_meta( $post->ID, 'primary_cat', $primary_cat );
		}
	}

	/**
	 * Let's create a shortcode for these posts
	 *
	 */

	public function primary_cat_sc( $atts ) {
		// We want users to specify the name of the primary category that they want to query.  If they don't, we'll use Uncategorized as the default.
		$a = shortcode_atts( 
			array(
				'name' => 'uncategorized'
			), $atts );

		// Here we'll tell the shortcode to generate a Query of the latest 3 possible posts with Primary Categories set
		$primary_cat_query = new WP_Query( array( 
			'post_type' => 'any',
			'meta_key' => 'primary_cat',
			'meta_value' => $a['name'],
			'posts_per_page' => 3
			)
		);

		// Open the Query
		if ( $primary_cat_query -> have_posts() ) {
			// Generate a simple unordered list
			echo '<ul>';
			while ( $primary_cat_query -> have_posts() ) {

				$primary_cat_query -> the_post();
				// Generate the title of our post and the link as a list item
				echo '<li><h3><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>';
				echo '<div class="pc_excerpt"><p>' . get_the_excerpt() . '</p>';
				echo '<a href="' . get_permalink() . '" class="button">Read More</a></div>';

			}

			echo '</ul>';
		} else {

			echo "Whoops!  No posts match that Primary Category.";

		}

		wp_reset_postdata();
	}


	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Primary_Cat_Select_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Primary_Cat_Select_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/primary-cat-select-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Primary_Cat_Select_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Primary_Cat_Select_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/primary-cat-select-admin.js', array( 'jquery' ), $this->version, false );

	}

}
