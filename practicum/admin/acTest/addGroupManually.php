<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>jQuery UI Autocomplete Remote datasource demo</title>
	<link type="text/css" href="jquery.ui.all.css" rel="stylesheet" />
	<script type="text/javascript" src="jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="jquery.ui.core.js"></script>
	<script type="text/javascript" src="jquery.ui.widget.js"></script>
	<script type="text/javascript" src="jquery.ui.position.js"></script>
	<script type="text/javascript" src="jquery.ui.autocomplete.js"></script>
	<link type="text/css" href="demos.css" rel="stylesheet" />
	<script type="text/javascript">
	$(function() {
		function log(message) {
			$("<div/>").text(message).prependTo("#log");
			$("#log").attr("scrollTop", 0);
		}
		
		$("#birds").autocomplete({
			// TODO doesn't work when loaded from /demos/#autocomplete|remote
			source: "search.php",
			minLength: 1,
			select: function(event, ui) {
				log(ui.item ? ("Selected: " + ui.item.value + " aka " + ui.item.id) : "Nothing selected, input was " + this.value);
			}
		});
	});
	</script>
</head>
<body>

<div class="demo">

<div class="ui-widget">
	<label for="birds">Birds: </label>
	<input id="birds" />
</div>

<div class="ui-widget" style="margin-top:2em; font-family:Arial">
	Result:
	<div id="log" style="height: 200px; width: 300px; overflow: auto;" class="ui-widget-content"></div>
</div>

</div><!-- End demo -->

<div class="demo-description">
<p>
The Autocomplete widgets provides suggestions while you type into the field. Here the suggestions are bird names, displayed when at least two characters are entered into the field.
</p>
<p>
The datasource is a server-side script which returns JSON data, specified via a simple URL for the source-option. In addition, the minLength-option is set to 2 to avoid queries that would return too many results and the select-event is used to display some feedback.
</p>
</div><!-- End demo-description -->

</body>
</html>
