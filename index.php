<html>
<head>
<!--[if lt IE 9]><script language="javascript" type="text/javascript" src="excanvas.js"></script><![endif]-->
<script language="javascript" type="text/javascript" src="./jquery.min.js"></script>
<script language="javascript" type="text/javascript" src="./jquery.jqplot.min.js"></script>
<script language="javascript" type="text/javascript" src="./plugins/jqplot.pieRenderer.min.js"></script>
<link rel="stylesheet" type="text/css" href="./jquery.jqplot.css" />
<meta name="viewport" content="width=320, initial-scale=1">
<style>
body{
font-family: sans-serif;
}

#content {
     min-width: 320px;
	 max-width: 690px;
     margin: 0 auto;
     padding: 10px;
     overflow: auto;
}

form,#results    {
	background: -webkit-gradient(linear, bottom, left 175px, from(#CCCCCC), to(#EEEEEE));
	background: -moz-linear-gradient(bottom, #CCCCCC, #EEEEEE 175px);
	position:relative;
	text-decoration: none;
	-webkit-border-radius: 10px;
	-moz-border-radius: 10px;
	border-radius: 10px;
	padding:10px;
	border: 1px solid #cccccc;
	border: inset 1px solid #333;
	-webkit-box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.3);
	-moz-box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.3);
	box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.3);
	min-height: 300px;
}
form {
	width:320px;
	float: left;
	font-size: 14px;
	line-height: 24px;
	font-weight: bold;
	color: black;
}
#results {
	width:320px;
	float: right;
}
</style>
</head>
<body>
<div id="content">
<?
//include_once('functions.php');
include('functions.php');
$apiKey = "806e3e8e7b43f754c8f20e4f881766e3";
//print_r(getJSON('http://ws.audioscrobbler.com/2.0/?method=track.gettoptags&artist=radiohead&track=paranoid+android&api_key='.$apiKey.'&format=json'));
printForm();
print "<div id=\"results\">"; //Results Div
if (!empty($_POST)) {
	//Prep Variables
	$username = addslashes($_POST["username"]);
	$startDateM = firstOfMonth(date(m, strtotime($_POST["startdate"])));
	$endDateM = lastOfMonth(date(m, strtotime($_POST["enddate"])));
	$startDateU = epochTime(strtotime($_POST["startdate"]),strtotime("00:00:00"));
	$endDateU = epochTime(strtotime($_POST["enddate"]),strtotime("23:59:59"));

	//Do Magic
	//Get Totals
	$recentTracks = getJSON('http://ws.audioscrobbler.com/2.0/?method=user.getrecenttracks&user='.$username.'&api_key='.$apiKey.'&format=json&limit=1');
	$recentTracksDates = getJSON('http://ws.audioscrobbler.com/2.0/?method=user.getrecenttracks&user='.$username.'&api_key='.$apiKey.'&from='.$startDateU.'&to='.$endDateU.'&format=json&limit=1');
	$recentTracksMonth = getJSON('http://ws.audioscrobbler.com/2.0/?method=user.getrecenttracks&user='.$username.'&api_key='.$apiKey.'&from='.$startDateM.'&to='.$endDateM.'&format=json&limit=1');
	$total = $recentTracks[recenttracks]['@attr'][total];
	$totalInTime = $recentTracksDates[recenttracks]['@attr'][total];
	$totalInMonth = $recentTracksMonth[recenttracks]['@attr'][total];
	


	
	//Output Results
	//Output Totals
	print "<strong>Total Tracks listened to:</strong> ".$total."<br />";
	print "<strong>Total Tracks listened to from ".changeDateFormat($startDate)." to ".changeDateFormat($endDate).":</strong> ".$totalInTime."<br />";
	print "<strong>Total Tracks listened to from 1st ".date(F, strtotime($_POST["startdate"]))." to 30th ".date(F, strtotime($_POST["enddate"])).":</strong> ".$totalInMonth;
	
	//Test Chart
	//print "<div id=\"totalPercentPie\" style=\"height:400px;width:300px; \"></div>";
	print "
	<script class=\"code\" type=\"text/javascript\">
$(document).ready(function(){
    var plot1 = $.jqplot('pie1', [[['a',25],['b',14],['c',7]]], {
        gridPadding: {top:0, bottom:38, left:0, right:0},
        seriesDefaults:{
            renderer:$.jqplot.PieRenderer, 
            trendline:{ show:false }, 
            rendererOptions: { padding: 8, showDataLabels: true }
        },
        legend:{
            show:true, 
            placement: 'outside', 
            rendererOptions: {
                numberRows: 1
            }, 
            location:'s',
            marginTop: '15px'
        }       
    });
});
	</script>";
	
	
	function genrePie(){
	//Genre Pie Chart
	global $total;
	
	$topTags = getJSON('http://ws.audioscrobbler.com/2.0/?method=track.gettoptags&mbid='.$mbid.'&api_key='.$apiKey.'&format=json');
	}
}
print "</div>"; /*Close Results Div */
?>

</div>
</body>
</html>