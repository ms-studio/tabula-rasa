jQuery(document).ready(function($){

/*
 * CONTENTS
 *
 *   1: Email Spam Protection 
 *
 */


/* 
 * 0: js-hidden must be hidden
 ****************************************************
 */
 $(".js-hidden").hide();


/* 
 * Outgoing Links = new window
 ****************************************************
 */

$("a[href^=http]").each(
	function(){
		if(this.href.indexOf(location.hostname) === -1) {
			$(this).attr('target', '_blank');
		}
	}
 );


/* 
 * 1.
 * EmailSpamProtection (jQuery Plugin)
 ****************************************************
 * Author: Mike Unckel
 * Source: http://unckel.de/labs/jquery-plugin-email-spam-protection
 *
 * How to use: Write each email in HTML in this way: 
 * <span class="email">info [at] domain.com</span>
 */
$.fn.emailSpamProtection = function(className) {
	return $(this).find("." + className).each(function() {
		var $this = $(this);
		var s = $this.text().replace(" [at] ", "&#64;");
		$this.html("<a href=\"mailto:" + s + "\">" + s + "</a>");
	});
};
$("body").emailSpamProtection("email");


/* 
 * that's it !
 ****************************************************
 */

}); // end document ready