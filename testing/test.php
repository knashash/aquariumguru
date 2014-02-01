<?php
//phpinfo();
//die();

mysql_connect("localhost", "guru_db", "b@tm@nDB") or
    die("Could not connect: " . mysql_error());
mysql_select_db("aquariumguru");


$result = mysql_query("SELECT id from `profiles_fish` where deleted=1");
while ($row = mysql_fetch_array($result))
{
	$profile_id = $row[0];
	
	$query = "Update common_names set deleted=1 where profile_id=$profile_id";
				echo $query."<br>";
				mysql_query($query);
}
?>