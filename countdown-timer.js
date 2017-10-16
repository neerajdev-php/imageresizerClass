
var is_expired=false;

function initasd_timer(getTime){

// Set the date we're counting down to
var countDownDate = new Date(getTime).getTime();

	// Update the count down every 1 second
var x = setInterval(function() {

    // Get todays date and time
    var now = new Date().getTime();
    
    // Find the distance between now an the count down date
    var distance = countDownDate - now;
    
    // Time calculations for days, hours, minutes and seconds
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
    // Output the result in an element with id="demo"
    document.getElementById("demo").innerHTML = days + "d " + hours + "h "
    + minutes + "m " + seconds + "s ";
    
    // If the count down is over, write some text 
    if (distance < 0) {
        clearInterval(x);
        document.getElementById("demo").innerHTML = "EXPIRED";
    }
}, 1000);




}
Date.prototype.addHours= function(h){
    this.setHours(this.getHours()+h);
    return this;
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

var delete_cookie = function(name) {
    document.cookie = name + '=;expires=Thu, 01 Jan 1970 00:00:01 GMT;';
};
jQuery(function(){


   jQuery('#login').click(function(){

   		var extendHours= new Date().addHours(1);
   		 console.log(extendHours);
          document.cookie = "userLoginTime="+extendHours+"; expires="+extendHours+"; path=/";
   		  initasd_timer(extendHours);
   		  return false;

   });

console.log(getCookie('userLoginTime'));

  if(getCookie('userLoginTime')){
  	initasd_timer(getCookie('userLoginTime'));
  }else{
  	  document.getElementById("demo").innerHTML = "Your time is EXPIRED";
  }


   
});

/*Usage:
<p id="demo"></p>
*/
