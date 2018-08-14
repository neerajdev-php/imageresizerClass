<?php 
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;
class team_Post_Type{
	public function __construct() {
	add_action( 'init', array( &$this, 'init' ) );
		if ( is_admin() ) {
			add_action( 'admin_init', array( &$this, 'admin_init' ) );
			add_action( 'restrict_manage_posts', array(&$this,'form_category_filter_list'));
			add_filter( 'parse_query',array(&$this,'team_category_filtering'));
			add_filter('manage_team_posts_columns', array(&$this,'ST4_columns_head_only_team_image'));
			add_action('manage_team_posts_custom_column', array(&$this,'ST4_columns_content_only_show_image'));
		}
		add_action( 'init', array( &$this, 'front_init' ) );
	}
	/** Frontend methods ******************************************************/
	/**
	 * Register the team post type
	 */
	public function init() {
	    register_post_type( 'team', array( 'public' => true, 'label' => 'Our Team','supports' => array('title', 'editor','', 'thumbnail') ));
	}
	// ADD NEW COLUMN
	public function ST4_columns_head_only_team_image($defaults) {
		$defaults['title'] = 'Business title';
		$defaults['team_name'] = 'Full Name';
	    $defaults['featured_image'] = 'Team Image';
	    $defaults['featured'] = 'Featured';
	    return $defaults;
	}
	// GET FEATURED IMAGE
	public function ST4_get_featured_image($post_ID) {
	    $post_thumbnail_id = get_post_thumbnail_id($post_ID);
	    if ($post_thumbnail_id) {
	        $post_thumbnail_img = wp_get_attachment_image_src($post_thumbnail_id, 'featured_preview');
	        return $post_thumbnail_img[0];
	    }
	}
	// SHOW THE FEATURED IMAGE
	public function ST4_columns_content_only_show_image($column_name) {
		global $post;
		if ($column_name == 'featured_image') {
	        $post_featured_image = $this->ST4_get_featured_image($post->ID);
	        if ($post_featured_image) {
	            echo '<img src="' . $post_featured_image . '" width="50"/>';
	        }
	    }
		if ($column_name == 'featured') {
	     	$featured =  $featured = get_post_meta($post->ID,'featured',true);
	        if ($featured) {
	            echo $featured ;
	        }
	    }
		if ($column_name == 'team_name') {
	     	$fname =  $featured = get_post_meta($post->ID,'team_first_name',true);
	     	$lname =  $featured = get_post_meta($post->ID,'team_last_name',true);
	        if ($fname) {
	            echo $fname.' '.$lname ;
	        }
	    }
	}
	/* Add custom category taxonomy filter on listing page */
	public function form_category_filter_list() {
	    $screen = get_current_screen();
	    global $wp_query;
	    if ( $screen->post_type == 'team' ) {
	        wp_dropdown_categories( array(
	            'show_option_all' => 'Show All Department',
	            'taxonomy' => 'team_cat',
	            'name' => 'team_cat',
	            'orderby' => 'name',
	            'selected' => ( isset( $wp_query->query['team_cat'] ) ? $wp_query->query['team_cat'] : '' ),
	            'hierarchical' => false,
	            'depth' => 3,
	            'show_count' => true,
	            'hide_empty' => true,
	        ) );
	    }
	}

	/* display filter results */
	public function team_category_filtering( $query ) {
	    $qv = &$query->query_vars;
	    if ( ( $qv['team_cat'] ) && is_numeric( $qv['team_cat'] ) ) {
	        $term = get_term_by( 'id', $qv['team_cat'], 'team_cat' );
	        $qv['team_cat'] = $term->slug;
	    }
	}

	/** Admin methods ******************************************************/
	
	
	/**
	 * Initialize the admin, adding actions to properly display and handle 
	 * the Book custom post type add/edit page
	 */
	public function admin_init() {
		global $pagenow;
		
		if ( $pagenow == 'post-new.php' || $pagenow == 'post.php' || $pagenow == 'edit.php' ) {
			
			add_action( 'add_meta_boxes', array( &$this, 'meta_boxes' ) );
			add_filter( 'enter_title_here', array( &$this, 'enter_title_here' ), 1, 2 );
			add_action( 'save_post', array( &$this, 'meta_boxes_save' ), 1, 2 );

			add_action( 'load-edit.php', array( &$this, 'sp_help_tabs' ) );
			add_action( 'load-post.php', array( &$this, 'sp_help_tabs' ) );
			
		}
	}

	public function front_init() {

		add_shortcode( 'Team', array( &$this, 'team_home_parameters_shortcode'));

	}

	/**
	 * Save meta boxes
	 * 
	 * Runs when a post is saved and does an action which the write panel save scripts can hook into.
	 */
	public function meta_boxes_save( $post_id, $post ) {
		if ( empty( $post_id ) || empty( $post ) || empty( $_POST ) ) return;
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
		if ( is_int( wp_is_post_revision( $post ) ) ) return;
		if ( is_int( wp_is_post_autosave( $post ) ) ) return;
		if ( ! current_user_can( 'edit_post', $post_id ) ) return;
		if ( $post->post_type != 'team' ) return;
			
		$this->process_team_meta( $post_id, $post );
	}
	

	/**
	 * Function for processing and storing all book data.
	 */
	private function process_team_meta( $post_id, $post ) {
		update_post_meta( $post_id, 'featured', $_POST['featured'] );
		update_post_meta( $post_id, 'team_first_name', $_POST['tfn'] );
		update_post_meta( $post_id, 'team_last_name', $_POST['tln'] );
		update_post_meta( $post_id, 'team_email', $_POST['temail'] );
		$fullname  = $_POST['tfn'].' '.$_POST['tln'];
		update_post_meta( $post_id, 'team_full_name', $fullname);
	}
	

	/**
	 * Set a more appropriate placeholder text for the New Book title field
	 */
	public function enter_title_here( $text, $post ) {
		if ( $post->post_type == 'team' ) return __( 'Business Title' );
		return $text;
	}


	/**
	 * Add and remove meta boxes from the edit page
	 */
	public function meta_boxes() {
		add_meta_box( 'featured', __( 'Featured' ), array( &$this, 'team_featured_meta_box' ), "team", "side", "high", null);

		add_meta_box( 'teamfname', __( 'Team Information' ), array( &$this, 'team_information_meta_box' ), "team", "normal", "low", null);

		
	}


	/**
	 * Display the team meta box
	 */
	public function team_featured_meta_box() {
		global $post;
		
		$ts        = '';
		$ts        = get_post_meta( $post->ID, 'featured', true );
		$tsValue   =  !empty($ts) ? $ts : '';
		if($tsValue == 'Yes') {  $check = 'checked';}
		if($tsValue == 'No') {   $check1 = 'checked';}
		if($tsValue != ''){
			echo '<p><input type="radio" name="featured" value="Yes" '.$check.'> Yes</p>';
		    echo '<p><input type="radio" name="featured" value="No" '.$check1.'> No</p>';
		}else{
	
			echo '<p><input type="radio" name="featured" value="Yes"> Yes</p>';
		    echo '<p><input type="radio" name="featured" value="No" checked> No</p>';
		}
	}

	public function team_information_meta_box() {
		global $post;
		
		$ts        = '';
		$ts        = get_post_meta( $post->ID, 'team_first_name', true );
		$tsValue   =  !empty($ts) ? $ts : '';

		$ts1        = '';
		$ts1        = get_post_meta( $post->ID, 'team_last_name', true );
		$tsValue1   =  !empty($ts1) ? $ts1 : '';

		$ts2        = '';
		$ts2        = get_post_meta( $post->ID, 'team_email', true );
		$tsValue2   =  !empty($ts2) ? $ts2 : '';
		
		echo '<p class="label"><label for="acf-field-email"><strong>First Name</strong></label></p><p><input type="text" name="tfn" value="'.$tsValue.'" style="width:100%"></p>';

		echo '<p class="label"><label for="acf-field-email"><strong>Last Name</strong></label></p><p><input type="text" name="tln" value="'.$tsValue1.'"  style="width:100%""></p>';

		echo '<p class="label"><label for="acf-field-email"><strong>Email</strong></label></p><p><input type="email" name="temail" value="'.$tsValue2.'"  style="width:100%"></p>';


	}

	

	/* display all data in array */

	public function team_home_parameters_shortcode( $atts ) {	

		global $wpdb,$post;

			// define attributes and their defaults
		    extract( shortcode_atts( array (
		        
		        'order'    => 'asc',
		        'posts'    => -1,
		        
		    ), $atts ) );

		    // define query parameters based on attributes
		    $options = array(

		        'post_type'      => 'team',
		        'order'          => $order,
		        'posts_per_page' => $posts,
		        'post_status'    => 'publish',
		        'meta_query' => array(
					       array(
					           'key' => 'featured',
					           'value' => 'Yes', //array
					           'compare' => '=',
					       )
   						)
		    );

		    $query = new WP_Query( $options );

		    $html = '';

		    $html .= '<div class="custom_home_team"><ul>';

		    if ( $query->have_posts() ) :
		    	while ( $query->have_posts() ) : $query->the_post();

		    	$id        = get_the_id();
		        $aimage    = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'single-post-thumbnail' );
		        $position  = get_the_title($id);
		        $fname     = get_post_meta($id,'team_first_name',true);
		        $lname     = get_post_meta($id,'team_last_name',true);
		        $email     = get_post_meta($id,'team_email',true);

		        $linkmail  =  'mailto:'.$email;
		        $linkno    =  'javascript:void()';

		        $tsEmail   =  !empty($email) ? $linkmail : $linkno;

		        $dept   = get_the_terms($id,'team_cat',ARRAY_A); 

		        $deptName  = (isset($dept[0]->name) && !empty($dept[0]->name)) ?  $dept[0]->name : '';
 
		        $fullname  = $fname.' '.$lname;

		    		$html  .=  '<li>
                            <div class="inner_team_artea">
                                <div class="team_image"><img src="'.$aimage[0].'"></div>
                                <div class="team_name">'.$fullname.'</div>
                                <div class="team_position">'.$deptName.'</div>
                                <div class="team_bottom">
                                    <a href="javascript:void(0)" data-id="'.$id.'" data-class="popupBoxHTML" onclick="toggle_visibility(this);">Bio</a>
                                    <a href="'.$tsEmail.'">Email</a>
                                </div>
                            </div>
                        </li>';


		    endwhile;
		else :
			$html .= 'Sorry, no posts matched your criteria.';
			endif;
			wp_reset_query();
		$html .= '</ul></div>'; 

		$html .= '<div id="popupBoxHTML">
                <div class="popupBoxWrapper">
                  <div class="popupBoxContent">
                  <p><a href="javascript:void(0)"   data-class="popupBoxHTML"  onclick="toggle_visibility(this);">X</a></p>
                  <div class="popupContent"></div>
                    </div>
                </div>
            </div>';

		return $html;
	}

	public function sp_help_tabs() {

	    $screen = get_current_screen();

	    $screen_ids = array( 'edit-team', 'team' );

	    if ( ! in_array( $screen->id, $screen_ids ) ) {
	        return;
	    }

	    $screen->add_help_tab(
	        array(
	            'id'      => 'sp_overview',
	            'title'   => 'Overview',
	            'content' => '<p>Display All Team Member Here</p>'
	        )
	    );

	    
		}
	
}
// finally instantiate our plugin class and add it to the set of globals
$GLOBALS['teammbs'] = new team_Post_Type();
?>