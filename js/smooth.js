/* path to the stylesheets for the color picker */


$(document).ready(function () {
	

	$("#menu h6 a").click(function () {
		var link = $(this);
		var value = link.attr("href");
		var id = value.substring(value.indexOf('#') + 1);

		var heading = $("#h-menu-" + id);
		var list = $("#menu-" + id);

		if (list.attr("class") == "closed") {
			heading.attr("class", "selected");
			list.attr("class", "opened");
		} else {
			heading.attr("class", "");
			list.attr("class", "closed");
		}
	});

	
});