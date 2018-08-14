<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;
include('class_team_post_type.php');
// Register Custom Taxonomy for forums
add_action( 'init',  'team_taxonomy');
  function team_taxonomy() {

    $labels = array(
      'name'                       => _x( 'Department', 'Taxonomy General Name', 'text_domain' ),
      'singular_name'              => _x( 'Department', 'Taxonomy Singular Name', 'text_domain' ),
      'menu_name'                  => __( 'Department', 'text_domain' ),
      'all_items'                  => __( 'All Department', 'text_domain' ),
      'parent_item'                => __( 'Parent Department', 'text_domain' ),
      'parent_item_colon'          => __( 'Parent Department:', 'text_domain' ),
      'new_item_name'              => __( 'New Item Name', 'text_domain' ),
      'add_new_item'               => __( 'Add New Department', 'text_domain' ),
      'edit_item'                  => __( 'Edit Department', 'text_domain' ),
      'update_item'                => __( 'Update Department', 'text_domain' ),
      'view_item'                  => __( 'View Department', 'text_domain' ),
      'separate_items_with_commas' => __( 'Separate Department with commas', 'text_domain' ),
      'add_or_remove_items'        => __( 'Add or remove Department', 'text_domain' ),
      'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
      'popular_items'              => __( 'Popular Department', 'text_domain' ),
      'search_items'               => __( 'Search Department', 'text_domain' ),
      'not_found'                  => __( 'Not Found', 'text_domain' ),
      'no_terms'                   => __( 'No Department', 'text_domain' ),
      'items_list'                 => __( 'Department list', 'text_domain' ),
      'items_list_navigation'      => __( 'Department list navigation', 'text_domain' ),
    );
    $args = array(
      'labels'                     => $labels,
      'hierarchical'               => true,
      'public'                     => true,
      'show_ui'                    => true,
      'show_admin_column'          => true,
      'show_in_nav_menus'          => true,
      'show_tagcloud'              => true,
      'query_var'         => true,
        'rewrite'           => array( 'slug' => 'team_cat' ),
    );
    register_taxonomy( 'team_cat', array( 'team' ), $args );
}
/* add new widget here */
register_sidebar( array(
            'name'          => __( 'Footer 1', 'understrap' ),
            'id'            => 'footer1',
            'description'   => 'Right sidebar widget area',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ) );
register_sidebar( array(
            'name'          => __( 'Footer 2', 'understrap' ),
            'id'            => 'footer2',
            'description'   => 'Right sidebar widget area',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ) );
register_sidebar( array(
            'name'          => __( 'Footer 3', 'understrap' ),
            'id'            => 'footer3',
            'description'   => 'Right sidebar widget area',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ) );
register_sidebar( array(
            'name'          => __( 'Footer Copyright 1', 'understrap' ),
            'id'            => 'footer4',
            'description'   => 'Right sidebar widget area',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ) );
register_sidebar( array(
            'name'          => __( 'Footer Copyright 2', 'understrap' ),
            'id'            => 'footer5',
            'description'   => 'Right sidebar widget area',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ) );
 register_sidebar( array(
            'name'          => __( 'Footer Press Room', 'understrap' ),
            'id'            => 'footer6',
            'description'   => 'Right sidebar widget area',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ) );
register_sidebar( array(
            'name'          => __( 'Footer inner page', 'understrap' ),
            'id'            => 'footer_inner_page',
            'description'   => 'Right sidebar widget area',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ) );
/* home testimonial shortcode */
function home_testimonial(){
    global $wpdb;
    $args      =  array('post_type' => 'ktsprotype','order' => 'desc','posts_per_page'=> '3','post_status' => 'publish');
    $the_query = new WP_Query( $args );
    $html1 = '';
    $html1  .=  '<div class="custom_home_testimonial"><ul>';
    if ( $the_query->have_posts() ) :
        $i = 1;
        $imagearra = array();
        while ( $the_query->have_posts() ) : $the_query->the_post();
          $id       = get_the_id();
          $aimage   = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'single-post-thumbnail' );
          $position = get_post_meta($id,'position',true);
          $name     = get_post_meta($id,'name',true);
          $content  = get_post_meta($id,'testimonial_text',true);
          array_push($imagearra,$aimage[0]);
           if($i == 2){ $class = 'show_testcon'; $class1 = 'imageCenter'; $class2 = 'imageCircle'; $class3 = 'middleimg';}else{ $class = 'hide_testcon'; $class1 = ''; $class2 = '';$class3 = '';}
            $html1  .=  '<li class="'.$class2.'" id="rotateslide-'.$i.'">
                            <div class="test_image '.$class3.'" data-id="'.$id.'" data-src="'.$aimage[0].'"><img src="'.$aimage[0].'" class="'.$class1.'"></div>
                                <div class="active22 test_content_'.$id.' '.$class.'">
								<div class="conecting_line"></div>
                                <div class="testi_name">'.$position.'</div>
                                <div class="testi_content">'.$content.'</div>
                                <div class="testi_position">'.$name.'</div>
                            </div>
                        </li>';
                    $i++;
        endwhile;
    else :
    $html1  .= 'Sorry, no posts matched your criteria.';
endif;
$html1  .=  '</ul></div>';
//$html1  .=  '<div class="testImageArray">'.json_encode($imagearra).'</div>';
 wp_reset_query();

 /*$html1 .=  '<script type="text/javascript">
                jQuery(function(){
                  //prepare Your data array with img urls
                    var dataArray= '.json_encode($imagearra).';
                    //start with id=0 after 5 seconds
                    var thisId=0;
                    window.setInterval(function(){
                        jQuery(".imageCenter").attr("src",dataArray[thisId]);
                        thisId++; //increment data array id
                        if (thisId==3) thisId=0; //repeat from start
                    },5000);        
                });
      </script>';*/
  return $html1;
}
add_shortcode('HOME-TESTIMONIAL','home_testimonial');
/* footer press room shortcode */
function footer_press_room_blog(){

	global $wpdb;
    $args      =  array('post_type' => 'post','order' => 'desc','posts_per_page'=> '2','post_status' => 'publish');
    $the_query = new WP_Query( $args );
    $html2 = '';
    $html2  .=  '<div class="footer_press"><ul>';
    if ( $the_query->have_posts() ) :
        while ( $the_query->have_posts() ) : $the_query->the_post();
          $id       = get_the_id();
          $name     = get_the_title($id);
          $content  = get_the_content($id);
          $date     = get_the_date( 'F Y', $id );; 
          $html2  .=  '<li><span class="fred">'.$date.'</span>
            				<p>'.substr($content,0,190).'</p>
							<span class="fgreen"><a href="'.get_permalink().'">'.$name.'</a></span>
						</li>';
        endwhile;
    else :
    $html2  .= 'Sorry, no posts matched your criteria.';
endif;
$html2  .=  '</ul></div>';
 wp_reset_query();
 return $html2;
}
add_shortcode('FOOTER-PRESS','footer_press_room_blog');
/* community blog display here */
function comm_press_room_blog(){

	global $wpdb;
    $args      =  array('post_type' => 'post','order' => 'desc','posts_per_page'=> '5','post_status' => 'publish');
    $the_query = new WP_Query( $args );
    $html3 = '';
    $html3  .=  '<div class="loop_blog_area"><ul>';
    if ( $the_query->have_posts() ) :
          while ( $the_query->have_posts() ) : $the_query->the_post();
          $id       = get_the_id();
          $name     = get_the_title($id);
          $content  = get_the_content($id);
          $date     = get_the_date( 'F Y', $id );; 
          $html3  .=  '<li><span class="blog_date">'.$date.'</span>
            				<span class="blog_name"><a href="'.get_permalink().'">'.$name.'</a></span>
            				<div class="blog_content"><p>'.substr($content,0,300).'</p></div>
							
						</li>';
                    
        endwhile;
    else :
    $html3  .= 'Sorry, no posts matched your criteria.';
endif;
$html3  .=  '</ul>';
$html3 .= '</div>';
if (function_exists('custom_pagination')) {
      //  pr($the_query);
        $html3 .= custom_pagination($the_query->max_num_pages,"",$paged);
      }
wp_reset_query();
 return $html3;
}
add_shortcode('PRESS','comm_press_room_blog');
/* custom pagination */
function custom_pagination($numpages = '', $pagerange = '', $paged='') {
  if (empty($pagerange)) {
    $pagerange = 2;
  }
  global $paged;
  if (empty($paged)) {
    $paged = 1;
  }
  if ($numpages == '') {
    global $wp_query;
    $numpages = $wp_query->max_num_pages;
    if(!$numpages) {
        $numpages = 1;
    }
  }
 
  /** 
   * We construct the pagination arguments to enter into our paginate_links
   * function. 
   */
  $pagination_args = array(
    'base'            => get_pagenum_link(1) . '%_%',
    'format'          => 'page/%#%',
    'total'           => $numpages,
    'current'         => $paged,
    'show_all'        => False,
    'end_size'        => 1,
    'mid_size'        => $pagerange,
    'prev_next'       => True,
    'prev_text'       => __('&laquo;'),
    'next_text'       => __('&raquo;'),
    'type'            => 'plain',
    'add_args'        => false,
    'add_fragment'    => ''
  );

  $paginate_links = paginate_links($pagination_args);
  
  if ($paginate_links) {
    $ht .= '<div class="ast-pagination ast-custom-pagination">';
    $ht .= "<nav class='navigation pagination'>";
    $ht .= '<div class="nav-links">';
     $ht .= $paginate_links;
    $ht .= "</div>";
    $ht .= "</nav>";
    $ht .= "</div>";
    return $ht;
  }
 
}
/* team filter function here */
function team_filter_html(){

	global $wpdb;
	$dept  =  get_terms('team_cat',array('hide_empty'=>true));
  $azRange = range('A', 'Z');
	$filterhtml  =  '';
	$filterhtml .=  '<div class="team_filter_section">
						<form name="search_team_filter" class="search_team_filter">
							<div class="filter_head">	
								<label>Name/Keyword</label>
								<input type="text" name="team_keyword" class="team_keyword" value="">
							</div>
							<div class="filter_head">	
								<label>Department</label>
								<select class="team_dept" name="" onchange="fkd(this.value);">
								<option value=""></option>
								';
								foreach ($dept as $key => $value) {
									$filterhtml .= '<option value="'.$value->term_id.'">'.$value->name.'</option>';
								}
								$filterhtml .= '</select>
							</div>
						</form>
					 </div>';
	$filterhtml .=  '<div class="team_alpha_filter"><ul>';
						foreach ($azRange as $letter)
						{
							$filterhtml .= '<li data-id="'.$letter.'" onclick="alphaFilter(this);">'.$letter.'</li>';
						}
	$filterhtml .= '</ul></div>';
  /* by default display team member here */
  $options = array(

		        'post_type'      => 'team',
		        'order'          => 'desc',
		        'posts_per_page' => 12,
		        'post_status' => 'publish'
		    );
  $query = new WP_Query( $options );
  $filterhtml .=  '<div class="custom_repet_team home_team_section"><div class="innser_team_section"><div class="display_default_member_area custom_home_team"><ul id="scroll_team_display">';
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
						$fullname  = $fname.' '.$lname;
            $deptName  = (isset($dept[0]->name) && !empty($dept[0]->name)) ?  $dept[0]->name : '';
            $filterhtml  .=  '<li>
				                            <div class="inner_team_artea">
				                                <div class="team_image"><img src="'.$aimage[0].'"></div>
				                                <div class="team_name">'.$fullname.'</div>
				                                <div class="team_position">'.$deptName.'</div>
				                                <div class="team_bottom">
				                 				<a href="javascript:void(0)" data-id="'.$id.'" data-class="popupBoxHTML" onclick="toggle_visibility(this);">Bio</a>
				                                   
				                                </div>
				                            </div>
                        			</li>';
          endwhile;
					else :
    $filterhtml .= 'Sorry, no team matched your criteria.';
    endif;
	$filterhtml .= '</ul><div id="test_scroll"></div><div class="team_loader"><img src="'.get_stylesheet_directory_uri().'/loading.gif"></div></div></div><input type="hidden" name="foot_current" id="foot_current" value=""><input type="hidden" class="total_team_page" value="'.$query->max_num_pages.'"><input type="hidden" class="team_alpha_string" value=""><input type="hidden" class="team_check_count" value="2"><input type="hidden" class="team_keyword_string" value=""><input type="hidden" class="team_dept_val" value=""></div>';

	wp_reset_query();
  $filterhtml .= '<div id="popupBoxHTML">
                <div class="popupBoxWrapper">
                  <div class="popupBoxContent">
                  <p><a href="javascript:void(0)"   data-class="popupBoxHTML"  onclick="toggle_visibility(this);">X</a></p>
                  <div class="popupContent"></div>
                    </div>
                </div>
            </div>';
  return $filterhtml;
}
add_shortcode('Team-Filter','team_filter_html');
/* get teammember  popup data*/
add_action('wp_ajax_get_team_popup_data','process_get_team_popup_data');
add_action('wp_ajax_nopriv_get_team_popup_data','process_get_team_popup_data');
function process_get_team_popup_data(){

  global $wpdb;
  $teamId   =  intval($_POST['teamId']);
  $aimage    = wp_get_attachment_image_src( get_post_thumbnail_id( $teamId ), 'single-post-thumbnail' );
  $position  = get_the_title($teamId);
  $fname     = get_post_meta($teamId,'team_first_name',true);
  $lname     = get_post_meta($teamId,'team_last_name',true);
  $email     = get_post_meta($teamId,'team_email',true);
  $linkmail  =  'mailto:'.$email;
  $linkno    =  'javascript:void()';
  $tsEmail   =  !empty($email) ? $linkmail : $linkno;
  $fullname  = $fname.' '.$lname;
  $page_object = get_page( $teamId );
  $bioText     =  $page_object->post_content;
  $html   =  '<div class="inner_team-poipup_content">
                  <div class="team_popup_image_left"><img src="'.$aimage[0].'"></div>
                  <div class="both_side_content">
                    <div class="team_popup_content-right">
                      <h1>'.$fullname.'</h1>
                      <div class="team_bio_text">'.$bioText.'</div>
                    </div>
                    <div class="popup_bottom_link">
                      <a href="javascript:void(0)">Bio</a>
                      <a href="'.$tsEmail.'">Email</a>
                  </div>
                  </div>
              </div>';
echo $html;           
die;  
}
/* ajax infinit team result here */
add_action('wp_ajax_infinite_scroll_team','process_infinite_scroll_team');
add_action('wp_ajax_nopriv_infinite_scroll_team','process_infinite_scroll_team');
function process_infinite_scroll_team(){
    global $wpdb;
    $pageno     =  intval($_POST['page_no']);
    $alphatext  =  sanitize_text_field($_POST['apphaText']);
    $tKeyword   =  sanitize_text_field($_POST['tKeyword']);
    $tDept      =  intval($_POST['tDept']);

    if($alphatext != ''){

      /* when user click on apha */
        $options  = array(
                          'post_type'      => 'team',
                          'order'          => 'desc',
                          'posts_per_page' =>  12,
                          'post_status'    => 'publish',
                          'paged'          => $pageno,
                          'meta_query'     => array(
                                array(
                                    'key'     =>  'team_first_name',
                                    'value'   =>  '^'.$alphatext.'.*',
                                    'compare' => 'REGEXP'
                                  ),
                             )
                      );

    }elseif($tKeyword != '' && $tDept == 0){

     $options  = array(

                        'paged'          => $pageno,
                        'post_type'      => 'team',
                        'order'          => 'desc',
                        'posts_per_page' =>  12,
                        'post_status'    => 'publish',
                        'orderby'        => 'team_first_name',
                        'search'         => '*' . esc_attr( $tKeyword ) . '*',
                        'meta_query'     => array(
                            'relation' => 'OR',
                              array(
                                  'key'     =>  'team_first_name',
                                  'value'   =>  $tKeyword,
                                  'compare' => 'LIKE'
                                ),array(
                                  'key'     =>  'team_last_name',
                                  'value'   =>  $tKeyword,
                                  'compare' => 'LIKE'
                                ),array(
                                  'key'     =>  'team_full_name ',
                                  'value'   =>  $keyword,
                                  'compare' => 'LIKE'
                                ),
                           )
                    );


    }elseif($tKeyword == '' && $tDept != 0){

       $options  = array(

                        'paged'          => $pageno,
                        'post_type'      => 'team',
                        'order'          => 'desc',
                        'posts_per_page' =>  12,
                        'post_status'    => 'publish',
                        'tax_query' => array(
                                                array(
                                                    'taxonomy' => 'team_cat',
                                                    'terms'    =>  $tDept,
                                                    'field'    => 'term_id',
                                                )
                                            ),
                       
                    );

    }elseif($tKeyword != '' && $tDept != 0){

      $keydept  = array(

                        'paged'          => $pageno,
                        'post_type'      => 'team',
                        'order'          => 'desc',
                        'posts_per_page' =>  12,
                        'post_status'    => 'publish',
                        'search'         => '*' . esc_attr( $tKeyword ) . '*',
                        'tax_query'      => array(
                                                array(
                                                    'taxonomy' => 'team_cat',
                                                    'terms'    =>  $tDept,
                                                    'field'    => 'term_id',
                                                )
                                            ),
                         'meta_query'     => array(
                            'relation' => 'OR',
                              array(
                                  'key'     =>  'team_first_name',
                                  'value'   =>  $tKeyword,
                                  'compare' => 'LIKE'
                                ),array(
                                  'key'     =>  'team_last_name',
                                  'value'   =>  $tKeyword,
                                  'compare' => 'LIKE'
                                ),array(
                                  'key'     =>  'team_full_name ',
                                  'value'   =>  $tKeyword,
                                  'compare' => 'LIKE'
                                ),
                           )
                       
                    );

    }else{

      $options = array(
            'post_type'      => 'team',
            'order'          => 'desc',
            'posts_per_page' => 12,
            'paged'          => $pageno,
            'post_status' => 'publish'
        );

    }

   $query = new WP_Query( $options );
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
            $fullname  = $fname.' '.$lname;
            $dept   = get_the_terms($id,'team_cat',ARRAY_A);
            $deptName  = (isset($dept[0]->name) && !empty($dept[0]->name)) ?  $dept[0]->name : '';
            $filterhtml  .=  '<li>
                                    <div class="inner_team_artea">
                                        <div class="team_image"><img src="'.$aimage[0].'"></div>
                                        <div class="team_name">'.$fullname.'</div>
                                        <div class="team_position">'.$deptName.'</div>
                                        <div class="team_bottom">
                                <a href="javascript:void(0)" data-id="'.$id.'" data-class="popupBoxHTML" onclick="toggle_visibility(this);">Bio</a>
                                            
                                        </div>
                                    </div>
                              </li>';
            endwhile;
          else :
        $filterhtml .= 'Sorry, no team matched your criteria.';
      endif;
wp_reset_query();
echo $filterhtml;
die;
}
/* filter team alpha */
add_action('wp_ajax_filter_alpha_team','process_filter_alpha_team');
add_action('wp_ajax_nopriv_filter_alpha_team','process_filter_alpha_team');
function process_filter_alpha_team(){

    global $wpdb;
    $alpha         =  sanitize_text_field($_POST['apha']);
    $optionsappha  = array(
                          'post_type'      => 'team',
                          'order'          => 'desc',
                          'posts_per_page' =>  12,
                          'post_status'    => 'publish',
                          'meta_query'     => array(
                                array(
                                    'key'     =>  'team_first_name',
                                    'value'   =>  '^'.$alpha.'.*',
                                    'compare' => 'REGEXP'
                                  ),
                             )
                      );
    $query = new WP_Query( $optionsappha );
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
          $fullname  = $fname.' '.$lname;
          $dept   = get_the_terms($id,'team_cat',ARRAY_A);
          $deptName  = (isset($dept[0]->name) && !empty($dept[0]->name)) ?  $dept[0]->name : '';
          $filterhtml  .=  '<li>
                                    <div class="inner_team_artea">
                                      <div class="team_image"><img src="'.$aimage[0].'"></div>
                                      <div class="team_name">'.$fullname.'</div>
                                      <div class="team_position">'.$deptName.'</div>
                                      <div class="team_bottom">
                                      <a href="javascript:void(0)" data-id="'.$id.'" data-class="popupBoxHTML" onclick="toggle_visibility(this);">Bio</a>
                                      </div>
                                    </div>
                              </li>';
    endwhile;
    $data  =  array('status' => 'ok','msg'=> $filterhtml,'max_page'=>$query->max_num_pages);
    else :
    $data = array('status'=>'fail','msg'=>'No team data found in this category.','max_page'=>0);
    endif;
    wp_reset_query();
    echo json_encode($data);
die;  
}
/* filter team by name keyword and dept */
add_action('wp_ajax_filter_keyword_dept','process_filter_keyword_dept');
add_action('wp_ajax_nopriv_filter_keyword_dept','process_filter_keyword_dept');
function process_filter_keyword_dept(){
  global $wpdb;
  $keyword  = sanitize_text_field($_POST['keyword']);
  $dept     = intval($_POST['dept']);

  if($keyword != '' && $dept == 0){

    $keydept  = array(
                        'post_type'      => 'team',
                        'order'          => 'desc',
                        'posts_per_page' =>  12,
                        'post_status'    => 'publish',
                        'orderby'        => 'team_first_name',
                        'search'         => '*' . esc_attr( $keyword ) . '*',
                        'meta_query'     => array(
                            'relation' => 'OR',
                              array(
                                  'key'     =>  'team_first_name',
                                  'value'   =>  $keyword,
                                  'compare' => 'LIKE'
                                ),array(
                                  'key'     =>  'team_last_name',
                                  'value'   =>  $keyword,
                                  'compare' => 'LIKE'
                                ),array(
                                  'key'     =>  'team_full_name ',
                                  'value'   =>  $keyword,
                                  'compare' => 'LIKE'
                                ),
                           )
                    );
    
  }elseif($keyword == '' && $dept != 0){

     $keydept  = array(
                        'post_type'      => 'team',
                        'order'          => 'desc',
                        'posts_per_page' =>  12,
                        'post_status'    => 'publish',
                        'tax_query' => array(
                                                array(
                                                    'taxonomy' => 'team_cat',
                                                    'terms'    =>  $dept,
                                                    'field'    => 'term_id',
                                                )
                                            ),
                       
                    );



  }elseif($keyword != '' && $dept != 0){

     $keydept  = array(
                        'post_type'      => 'team',
                        'order'          => 'desc',
                        'posts_per_page' =>  12,
                        'post_status'    => 'publish',
                        'search'         => '*' . esc_attr( $keyword ) . '*',
                        'tax_query'      => array(
                                                array(
                                                    'taxonomy' => 'team_cat',
                                                    'terms'    =>  $dept,
                                                    'field'    => 'term_id',
                                                )
                                            ),
                         'meta_query'     => array(
                            'relation' => 'OR',
                              array(
                                  'key'     =>  'team_first_name',
                                  'value'   =>  $keyword,
                                  'compare' => 'LIKE'
                                ),array(
                                  'key'     =>  'team_last_name',
                                  'value'   =>  $keyword,
                                  'compare' => 'LIKE'
                                ),array(
                                  'key'     =>  'team_full_name ',
                                  'value'   =>  $keyword,
                                  'compare' => 'LIKE'
                                ),
                           )
                       
                    );

  }else{

      $keydept  = array(
                        'post_type'      => 'team',
                        'order'          => 'desc',
                        'posts_per_page' =>  12,
                        'post_status'    => 'publish',
                    );

  }

  $query = new WP_Query( $keydept );

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
          $fullname  = $fname.' '.$lname;
          $dept   = get_the_terms($id,'team_cat',ARRAY_A);
          $deptName  = (isset($dept[0]->name) && !empty($dept[0]->name)) ?  $dept[0]->name : '';
          $filterhtml  .=  '<li>
                                    <div class="inner_team_artea">
                                      <div class="team_image"><img src="'.$aimage[0].'"></div>
                                      <div class="team_name">'.$fullname.'</div>
                                      <div class="team_position">'.$deptName.'</div>
                                      <div class="team_bottom">
                                      <a href="javascript:void(0)" data-id="'.$id.'" data-class="popupBoxHTML" onclick="toggle_visibility(this);">Bio</a>
                                      </div>
                                    </div>
                              </li>';
    endwhile;
    $data  =  array('status' => 'ok','msg'=> $filterhtml,'max_page'=>$query->max_num_pages);
    else :
    $data = array('status'=>'fail','msg'=>'No team data found in this category.','max_page'=>0);
    endif;
    wp_reset_query();
    echo json_encode($data);
die;  
}