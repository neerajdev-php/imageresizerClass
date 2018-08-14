<?php 
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
  wp_reset_query();

  $html1  .= "<script>
				jQuery(document).ready(function(){
					jQuery('.test_image').click(function(){
						
						var id  		 = jQuery(this).attr('data-id');
						var imgefirstSrc = jQuery(this).attr('data-src');
						var centerImage  = jQuery('.imageCenter').attr('src');
						var middleImgId  = jQuery('.middleimg').attr('data-id');

						jQuery('.imageCenter').attr('src',imgefirstSrc).slideDown('slow');
						jQuery(this).find('img').attr('src',centerImage).slideDown('slow');
						jQuery(this).attr('data-src',centerImage);
						jQuery('.active22').hide();

						var middlecontent = jQuery('.test_content_'+middleImgId).html();
						var clickcontent  = jQuery('.test_content_'+id).html();
						
						jQuery('.test_content_'+middleImgId).toggle();
						jQuery('.test_content_'+id).html(middlecontent);
						jQuery('.test_content_'+middleImgId).html(clickcontent);
						jQuery(this).attr('data-id',middleImgId);
						jQuery('.middleimg').attr('data-id',id);
						jQuery('.middleimg').next('.active22').removeClass('test_content_'+middleImgId);
						jQuery('.middleimg').next('.active22').addClass('test_content_'+id);
						jQuery(this).next('.active22').removeClass('test_content_'+id);
						jQuery(this).next('.active22').addClass('test_content_'+middleImgId);
				});

					/* auto scroll every 5 mint */

					var thisId=1;
					window.setInterval(function(){
						if (thisId==2) thisId=3;
					    jQuery('#rotateslide-'+thisId).find('.test_image').trigger('click');
					    thisId++; //increment data array id
					    if (thisId>3) thisId=1; //repeat from start
					},5000);

				});
				</script>";

		$html1 .= '<style>
						.custom_home_testimonial .hide_testcon { display: none;}
						.custom_home_testimonial .active22 {width: calc(100% - 240px); float: right; background: #23395b; color: #fff; padding: 30px 50px; position: absolute; right: 0; top: 50%; transform: translateY(-50%); border: 1px solid #fff;}
						.custom_home_testimonial ul li {display: block;margin: 10px 0px;}
						.custom_home_testimonial .testi_name {font-size: 24px; text-align: center;font-family: "Vani";}
						.custom_home_testimonial .testi_position { text-align: center;}
						.testi_content {text-align: center; font-style: italic; font-size: 17px; padding: 10px 0; line-height: 28px; position:relative}
						.testi_content:before {content: ''; background: url(../quote.png) no-repeat center; height: 20px; width: 20px; position: absolute; top: -5px; background-size: 100% auto; left: 0;}
						.testi_content:after {content: ''; background: url(../quote.png) no-repeat center; height: 20px; width: 20px; position: absolute; bottom: 5px; background-size: 100% auto; margin-left: 10px; transform: scaleX(-1);}
						.home_testimonail_section {padding: 40px 0px; padding-top: 40px !important;}
						.imageCircle .test_image img {border: 1px solid #fff; border-radius: 50%; padding: 5px; box-sizing: content-box; position: relative; left: -5px;}
						.custom_home_testimonial ul li .test_image img{ cursor:pointer; max-width: 75px; border-radius: 50%;}
						.conecting_line{width: 120px; height: 1px; background: #fff; position: absolute; left: -90px; top: 0; bottom: 0; margin: auto; display:inline-block}
						.conecting_line:before, .conecting_line:after{content: ''; height: 9px; width: 9px; background: #fff; border-radius: 50%; position: absolute; top: 0; bottom: 0; margin: auto;}
						.conecting_line:after{right: 0; left:auto}
						.custom_home_testimonial ul li .test_image {display: inline-block;}
						@media (max-width:767px){
							.custom_home_testimonial ul li{ display:inline-block}
							.custom_home_testimonial ul {padding-left: 0; text-align: center;}
							.custom_home_testimonial .active22{top: auto; transform: none; width:100%; margin-top: 80px;}
							.custom_home_testimonial { min-height: 450px;}
							.custom_home_testimonial ul li .test_image { padding: 0 10px;}
							.testi_content{ max-height:150px; overflow:hidden}
						}
						@media (max-width:479px){
							.custom_home_testimonial ul li {max-width: 70px;}
						}
					</style>';

  return $html1;
}
add_shortcode('HOME-TESTIMONIAL','home_testimonial');
?>