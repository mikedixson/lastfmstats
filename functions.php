<?
function getJSON($url){
	//Gets url and parses JSON into an array
	$json = file_get_contents($url);
	$output = (json_decode($json, true));
	return $output;
}

function firstOfMonth($month){
	//Returns the first date of the month in appropriate format
	$firstofmonth = mktime(0, 0, 0, date("$month"), 1 , date("Y"));
	return $firstofmonth;
}

function lastOfMonth($month){
	//Returns the last date of the month in appropriate format
	$endofmonth = mktime(0, 0, -1, date("$month")+1  , date("d"), date("Y"));
	return $endofmonth;
}

function epochTime($date,$time){
	//Returns datetime as utime/time from epoch
	date_default_timezone_set('UTC');
	$epochtime = mktime(date(H, "$time"), date(i, "$time"), date(s, "$time"), date(m, "$date")  , date("d", "$date"), date("Y", "$date"));
	return $epochtime;
}

function changeDateFormat($source) {
	//Returns datetime as Y-m-d format aka YYYY-mm-dd
	$outputdate = new DateTime($source);
	return $outputdate->format('Y-m-d');
}

function dateDiff($datetime1,$datetime2,$scale) {
	//Returns the difference before two dates as an integer. Scale can be set as days/months/etc.
	$datetime1 = new DateTime($datetime1);
	$datetime2 = new DateTime($datetime2);
	$interval = $datetime1->diff($datetime2);
	print_r($interval);
	return $interval->format('%R%m '.$scale);
}

function dateDiffInWeeks($date1, $date2) {
	//Returns an integer of the number of weeks between two dates
    $first = DateTime::createFromFormat('Y-m-d', $date1);
    $second = DateTime::createFromFormat('Y-m-d', $date2);
    if($date1 > $date2) return datediffInWeeks($date2, $date1);
    return floor($first->diff($second)->days/7);
}

function setDefaultFields(){
	global $username;
	global $startDate;
	global $endDate;
	if (!empty($_POST)) {
		//Set default field values
		if (!empty($_POST["username"])){
			$username = $_POST["username"];
			} else {
				$username = "";
			}
		
		if (!empty($_POST["startdate"])){
			$startDate = $_POST["startdate"];
			} else {
				$startDate = "";
			}
		
		if (!empty($_POST["enddate"])){
			$endDate = $_POST["enddate"];
			} else {
				$endDate = "";
			}
	}
}

function printForm(){
	setDefaultFields();
	global $username;
	global $startDate;
	global $endDate;
	print "
	<form action=\"".$_SERVER['PHP_SELF']."\" method=\"post\">
	Last.fm Username<br />
	<input type=\"text\" name=\"username\" value=\"".$username."\" required><br />
	Start Date<br />
	<input type=\"date\" name=\"startdate\" value=\"".$startDate."\"><br />
	End Date<br />
	<input type=\"date\" name=\"enddate\" value=\"".$endDate."\"><br />
	<select name=\"daterange\">
	<option value=\"1\">1 Month</option>
	<option value=\"6\">6 Month</option>
	<option value=\"12\" selected>12 Months</option>
	<option value=\"0\">All Time</option>
	</select>
	<input type=\"hidden\" name=\"formsubmitted\" value=\"TRUE\"><br />
	<input type=\"submit\">
	</form>
	";
}
?>