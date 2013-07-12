/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
jQuery(document).ready(function(){
	var searchedText = jQuery('#search-result span').text();
	jQuery('.search-value').each(function() {
		searchAndHighlight(searchedText, jQuery(this));
	});

});

function searchAndHighlight(searchTerm, selector) {
    if(searchTerm) {
        var selector = selector || "body";
        var searchTermRegEx = new RegExp(searchTerm,"ig");
        var matches = jQuery(selector).text().match(searchTermRegEx);
        if(matches) {
			jQuery(selector).html(jQuery(selector).html().replace(searchTermRegEx, "<span class='highlighted'>"+searchTerm+"</span>"));
		}
	}
}
