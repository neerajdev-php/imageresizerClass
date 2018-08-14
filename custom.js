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

var thisId=1;
window.setInterval(function(){
	if (thisId==2) thisId=3;
    jQuery("#rotateslide-"+thisId).find('.test_image').trigger('click');
    thisId++; //increment data array id
    if (thisId>3) thisId=1; //repeat from start
},5000);


/* filter team here */	
	jQuery('body').on('click','.team_alpha_filter ul li',function(){
		var alpha  =  jQuery(this).attr('data-id');
   		jQuery( '.team_alpha_filter ul li' ).removeClass( "highlight" );
		jQuery( this ).toggleClass( "highlight" );
	});
/* team infinit scroll load */
var pathname = window.location.href;
if(pathname == frontend_ajax_object.team_url){
		var footval = jQuery('#test_scroll').offset().top - jQuery(window).height();
		jQuery("#foot_current").val(footval);
		jQuery(window).scroll(function(){
			var foot = jQuery("#foot_current").val();
			var scroll = jQuery(window).scrollTop();
			if (scroll >= foot) {
				var total     = jQuery('.total_team_page').val();
				var count     = jQuery('.team_check_count').val();
				var apphaText = jQuery('.team_alpha_string').val();
				var tKeyword  = jQuery('.team_keyword_string').val();
				var tDept     = jQuery('.team_dept_val').val();
				if (parseInt(count) > parseInt(total)){
		            return false;
		        }else{
		            loadTeam(count,apphaText,tKeyword,tDept);
		            foot = parseInt(foot) + parseInt(jQuery('.inner_team_artea').height());
		            jQuery("#foot_current").val(foot);
				}
		        count++;
		        jQuery('.team_check_count').val(count);
		    }
		});
		function loadTeam(pageNumber,apphaText,tKeyword,tDept){    
	                  jQuery('.team_loader').show();
	                  jQuery.ajax({
	                      url: frontend_ajax_object.ajaxurl,
	                      type:'post',
	                      data: "action=infinite_scroll_team&page_no="+ pageNumber+"&apphaText="+apphaText+"&tKeyword="+tKeyword+"&tDept="+tDept, 
	                      success: function(html){
	                          jQuery('.team_loader').hide();
	                          jQuery("#scroll_team_display").append(html);
	                      }
	                  });
	              return false;
		}
	}
/* name and category wise team filtyer */
jQuery('.team_keyword').keyup(function(){
	jQuery('.team_alpha_filter ul li').removeClass("highlight");
   var namekeyword  = jQuery('.team_keyword').val();
   var dep 			= jQuery('.team_dept').val();
   //if(namekeyword.length >= 3){
		team_filter_keyword_depart(namekeyword,dep);
	//}
});	
/* name and category wise team filtyer closed */
});
/* team popup */
function toggle_visibility(a) {
	var teamId = jQuery(a).attr('data-id');
	var id 	   = jQuery(a).attr('data-class');
	jQuery.ajax({
		    type: "post",
		    url: frontend_ajax_object.ajaxurl,
		    data : {action: "get_team_popup_data",'teamId':teamId},
		    success: function(msg){
		       jQuery('.popupContent').html(msg);
		       var e = document.getElementById(id);
			   if(e.style.display == 'block')
			      e.style.display = 'none';
			   else
			      e.style.display = 'block';
			}
		});
}
/* search by alpha */
function alphaFilter(str){
	jQuery(".team_keyword_string").val("");
	jQuery(".team_dept_val").val(""); 
	jQuery('.team_keyword').val("");
    jQuery('.team_dept').val("");
	jQuery("#foot_current").val(0);
	jQuery('.team_check_count').val(2);
	var apha = jQuery(str).attr('data-id');
	jQuery.ajax({
          url: frontend_ajax_object.ajaxurl,
          type:'post',
          dataType:'json',
          data: "action=filter_alpha_team&apha="+apha, 
          success: function(data){
			if(data.status == 'fail'){
          		jQuery("#scroll_team_display").html('<li class="no_team_data">'+data.msg+'</li>');
          		jQuery(".total_team_page").val(data.max_page); 
			}else{
          		jQuery('.team_alpha_string').val(apha);
          		jQuery("#scroll_team_display").html(data.msg); 
			    jQuery(".total_team_page").val(data.max_page); 
          	}
		}
      });
}
/* function team filter by namekeyword and dept */
function fkd(a){
	jQuery('.team_alpha_filter ul li').removeClass("highlight");
   var namekeyword  = jQuery('.team_keyword').val();
   team_filter_keyword_depart(namekeyword,a);
}
function team_filter_keyword_depart(a,b){
	jQuery("#foot_current").val(0);
	jQuery('.team_check_count').val(2);
	jQuery('.team_alpha_string').val("");
	jQuery.ajax({
          url: frontend_ajax_object.ajaxurl,
          type:'post',
          dataType:'json',
          data: "action=filter_keyword_dept&keyword="+a+"&dept="+b, 
          success: function(data){
			if(data.status == 'fail'){
          		jQuery("#scroll_team_display").html('<li class="no_team_data">'+data.msg+'</li>');
          		jQuery(".total_team_page").val(data.max_page); 
			}else{
          		
          		jQuery("#scroll_team_display").html(data.msg); 
			    jQuery(".total_team_page").val(data.max_page);
			    jQuery(".team_keyword_string").val(a);
			    jQuery(".team_dept_val").val(b); 
          	}
		}
      });
}