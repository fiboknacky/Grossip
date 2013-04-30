<?php 
session_name('linkedin-api');
session_start();
// include "clearsession.php";
// if ((empty($_SESSION['expires_at'])) || (time() > $_SESSION['expires_at'])) {
// 	header("Location: connect-linkedin.php");
// }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Grossip</title>
<style type="text/css"> 
<!-- 
body  {
	font: 100% Helvetica, "Palatino Linotype", "Book Antiqua", Palatino, serif;
	background: #E6E6E6 url(images/main-bg.png) repeat;
	margin: 1em 0 1em 0; /* it's good practice to zero the margin and padding of the body element to account for differing browser defaults */
	padding: 0;
	text-align: center; /* this centers the container in IE 5* browsers. The text is then set to the left aligned default in the #container selector */
	color: #000000;
}
.sidebar a {
	color: #F0E68C;
}

/* Tips for Elastic layouts 
1. Since the elastic layouts overall sizing is based on the user's default fonts size, they are more unpredictable. Used correctly, they are also more accessible for those that need larger fonts size since the line length remains proportionate.
2. Sizing of divs in this layout are based on the 100% font size in the body element. If you decrease the text size overall by using a font-size: 80% on the body element or the #container, remember that the entire layout will downsize proportionately. You may want to increase the widths of the various divs to compensate for this.
3. If font sizing is changed in differing amounts on each div instead of on the overall design (ie: #sidebar1 is given a 70% font size and #mainContent is given an 85% font size), this will proportionately change each of the divs overall size. You may want to adjust these divs based on your final font sizing.
*/
.twoColElsLt #container { 
	width: 66em;  /* this width will create a container that will fit in an 800px browser window if text is left at browser default font sizes */
	background: #FFFFFF;
	margin: 0 auto; /* the auto margins (in conjunction with a width) center the page */
	/*border: 1px solid #000000;*/
	text-align: left; /* this overrides the text-align: center on the body element. */
	box-shadow: 0px 0px 20px rgba(0,0,0,.3);
} 

/* Tips for sidebar1:
1. Be aware that if you set a font-size value on this div, the overall width of the div will be adjusted accordingly.
2. Since we are working in ems, it's best not to use padding on the sidebar itself. It will be added to the width for standards compliant browsers creating an unknown actual width. 
3. Space between the side of the div and the elements within it can be created by placing a left and right margin on those elements as seen in the ".twoColElsLt #sidebar1 p" rule.
*/
.twoColElsLt .sidebar{
	float: left; 
	width: 20em; /* since this element is floated, a width must be given */
	/*background: #EBEBEB; /* the background color will be displayed for the length of the content in the column, but no further */
	background: #445566;
	color: #FFFFFF;
	padding: 0px 0; /* top and bottom padding create visual space within this div */
}
.twoColElsLt .sidebar h3, .twoColElsLt .sidebar p {
	margin-left: 10px; /* the left and right margin should be given to every element that will be placed in the side columns */
	margin-right: 10px;
}

/* Tips for mainContent:
1. If you give this #mainContent div a font-size value different than the #sidebar1 div, the margins of the #mainContent div will be based on its font-size and the width of the #sidebar1 div will be based on its font-size. You may wish to adjust the values of these divs.
2. The space between the mainContent and sidebar1 is created with the left margin on the mainContent div.  No matter how much content the sidebar1 div contains, the column space will remain. You can remove this left margin if you want the #mainContent div's text to fill the #sidebar1 space when the content in #sidebar1 ends.
3. To avoid float drop, you may need to test to determine the approximate maximum image/element size since this layout is based on the user's font sizing combined with the values you set. However, if the user has their browser font size set lower than normal, less space will be available in the #mainContent div than you may see on testing.
4. In the Internet Explorer Conditional Comment below, the zoom property is used to give the mainContent "hasLayout." This avoids several IE-specific bugs that may occur.
*/
.twoColElsLt #mainContent {
 	margin: 0em 1em 0 21em; /* the right margin can be given in ems or pixels. It creates the space down the right side of the page. */
} 
.twoColElsLt #mainContent h3, .twoColElsLt #mainContent p {
	margin-top: 10px; /* the left and right margin should be given to every element that will be placed in the side columns */
	margin-right: 10px;
}

.input-text
{
width:170px;
height:25px;
/*font:Verdana, Geneva, sans-serif;*/
font-size:18px;
}

#footer
{
	height: 50px;
	margin: 0 auto;
	padding: 20px 0px 10px 0px;
}

#footer p
{
	text-shadow: 1px 1px 0px #FFFFFF;
	text-align: center;
	font-size: 14px;
	color: #4D565E;
}

/* Miscellaneous classes for reuse */
.fltrt { /* this class can be used to float an element right in your page. The floated element must precede the element it should be next to on the page. */
	float: right;
	margin-left: 8px;
}
.fltlft { /* this class can be used to float an element left in your page */
	float: left;
	margin-right: 8px;
}
.clearfloat { /* this class should be placed on a div or break element and should be the final element before the close of a container that should fully contain a float */
	clear:both;
    height:0;
    font-size: 1px;
    line-height: 0px;
}
--> 
</style><!--[if IE]>
<style type="text/css"> 
/* place css fixes for all versions of IE in this conditional comment */
.twoColElsLt #sidebar1 { padding-top: 30px; }
.twoColElsLt #mainContent { zoom: 1; padding-top: 15px; }
/* the above proprietary zoom property gives IE the hasLayout it needs to avoid several bugs */
</style>
<![endif]-->
		<link type="text/css" href="jquery-ui-1.10.2.custom/css/redmond/jquery-ui-1.10.2.custom.css" rel="stylesheet" />	
		<script type="text/javascript" src="jquery-ui-1.10.2.custom/js/jquery-1.9.1.js"></script>
		<script type="text/javascript" src="jquery-ui-1.10.2.custom/js/jquery-ui-1.10.2.custom.min.js"></script>
		<script type="text/javascript" src="spin.js"></script>
		<script type="text/javascript">

            $(document).ready(function(){ 
            	$('input').addClass("ui-corner-all");
            	$("button, input:submit, input:button").button();
            	$('input').addClass("ui-widget-content");
                $("#container").hide();
                // $("#loading").height(0);
                // $("#loading").width(0);
                $("#loading").css('margin',0);
                $("#loading").css('padding',0);
                $("#loading").css('border',0);
                // $("#loading").hide();
                // $("#loading").toggle(false);
                // $("#mainContent").hide();
                $("#searchform").submit(function (event){
                	event.preventDefault();
					var opts = {
					  lines: 9, // The number of lines to draw
					  length: 7, // The length of each line
					  width: 4, // The line thickness
					  radius: 11, // The radius of the inner circle
					  corners: 1, // Corner roundness (0..1)
					  rotate: 0, // The rotation offset
					  direction: 1, // 1: clockwise, -1: counterclockwise
					  color: '#000', // #rgb or #rrggbb
					  speed: 1.2, // Rounds per second
					  trail: 68, // Afterglow percentage
					  shadow: true, // Whether to render a shadow
					  hwaccel: false, // Whether to use hardware acceleration
					  className: 'spinner', // The CSS class to assign to the spinner
					  zIndex: 2e9, // The z-index (defaults to 2000000000)
					  top: 'auto', // Top position relative to parent in px
					  left: 'auto' // Left position relative to parent in px
					};
					$("#loading").empty();
					var target = document.getElementById('loading');
					var spinner = new Spinner(opts).spin(target);
					$('#container').toggle(false);

                	// $("#loading").show();
                	// $("#loading").html("<h3><center>Loading...</center></h3>");

                	var $form = $( this ),
				    term = $form.find( 'input[name="query"]' ).val(),
				    url = $form.attr( 'action' );
				 
				  	/* Company Search: send the data using post */
				  	var posting = $.post( url, { query: term, search: "GO!" } );

				   	/* Put the results in a div */
				  	posting.done(function( data ) {
				    	// var content = $( data ).find( '#content' );
				    	var content = data;
				    	$("#loading").empty();
				    	if (content == "NO"){
				    		$( "#loading" ).empty().append("<center><b>No Information Available. Please search for other companies.</b></center>");
				    	} else {
				    		$("#loading").hide();
				    		$( "#sidebar1" ).empty().append( content );	
				    		$('#container').toggle(true);
				    		$('#container').slideDown('slow');
				    	}
				    	
				    	
                	});

				  	$("#sidebar2").html("<h3><center>Loading...</center></h3>");
	                	/* Job Search: send the data using post */
					  	var alchemy = $.post( "alchemy-search.php", {  } );
					 
					   	/* Put the results in a div */
					  	alchemy.done(function( data ) {
					    	// var content = $( data ).find( '#content' );
					    	var content = data;
					    	// $("#loading").empty();
					    	if (content == "NO"){
					    		var shown = "<h4>No Tags</h4>";
					    		$( "#sidebar2" ).empty().append(shown);
					    	} else {
					    		// $("#loading").hide();
					    		$("#sidebar2" ).empty().append( content );	
					    		// $('#container').slideDown('slow');
					    	}
				    	
                		});

				  	$("#mainContent").html("<h3><center>Loading...</center></h3>");
	                	/* Job Search: send the data using post */
					  	var jobposting = $.post( "search-job.php", {  } );
					 
					   	/* Put the results in a div */
					  	jobposting.done(function( data ) {
					    	// var content = $( data ).find( '#content' );
					    	var content = data;
					    	// $("#loading").empty();
					    	if (content == "NO"){
					    		var shown = "<h4>No Jobs Currently Available for ";
					    		shown.concat(term);
					    		shown.concat(" </h4>");
					    		$( "#mainContent" ).empty().append(shown);
					    	} else {
					    		// $("#loading").hide();
					    		$("#mainContent" ).empty().append( content );	
					    		// $('#container').slideDown('slow');
					    	}
				    	
                		});
				  	
				 });

                // $("#freewordsubmit").click(function(e){
                //     $('#container').toggle(false);
                //     $.post('search-company.php', $('#searchform').serialize() +"&"+$.param(api_params), function(data) {
                //         $("#container").html(data);
                //         $('#container').slideDown('slow');
                //     });
                    // return e.preventDefault();
                // });
            });
        </script>
		
</head>

<body class="twoColElsLt">
<a id="top"></a>
<img id="banner" src="images/grossip-logo.png" width="450em" height="108em" alt="banner" /> 
<form action="search-company.php" method="post" enctype="multipart/form-data" id="searchform">
	<h4>Search for a company (e.g., GREE): 
        <input type="text" name="query" class="input-text">
        <input type="submit" name="search" value="GO!">
        </h4>
</form>
<div id="container">
  <div id="sidebar1" class="sidebar">
  <!-- end #sidebar1 --></div>
  
  <div id="mainContent">
    <h2>Jobs from GREE, Inc.</h2>
    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. </p>
    <p>Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.</p>    
	<!-- end #mainContent --></div>
	<div id="sidebar2" class="sidebar">
  <!-- end #sidebar2 --></div>
	<!-- This clearing element should immediately follow the #mainContent div in order to force the #container div to contain all child floats --><br class="clearfloat" />
<!-- end #container -->
</div>

<div id="loading"></div>
<div id="footer">
	<p><a href="#top">Return To Top</a></p>
	<p>Copyright (c) 2013 GREE, Inc. Designed By <a href="http://www.linkedin.com/profile/view?id=100814263" target="_blank">Thanet Knack Praneenararat</a></p>
</div>
</body>
</html>
