<?php
//phpinfo();
//die();

mysql_connect("localhost", "guru_db", "b@tm@nDB") or
    die("Could not connect: " . mysql_error());
mysql_select_db("aquariumguru");

$query = "SELECT main_fish.id,main_fish.diet_comments, main_fish.care_comments, main_fish.comments, main_fish.breeding_comments, main_fish.tempermant_comments, main_fish.sexing, MongaBayMainFish.Description, MongaBayMainFish.SocialBehavior, MongaBayMainFish.BreedingComments, MongaBayMainFish.OtherComments, MongaBayMainFish.OtherComments2 FROM main_fish LEFT JOIN MongaBayMainFish ON main_fish.id = MongaBayMainFish.ID";
$result = mysql_query($query);
while ($row = mysql_fetch_array($result))
{
	$profile_id = $row[0];
	
	if ($row[1] || $row[2] || $row[3] || $row[4] || $row[5] || $row[6] || $row[7] || $row[8] || $row[9] || $row[10] || $row[11])
	{
		$query2 = "UPDATE profiles_fish SET needs_edit=1 where id=$profile_id";
		echo $query2."<br>";
		$result2 = mysql_query($query2);
	}
	else echo "skipping profile ".$profile_id."<br>";
}
?>