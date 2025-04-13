<?php
include 'acccon.txt';
include 'chklogin.txt';
$ctr=0;
$sql="select * from students, login  where students.dacid=login.dacid  order by students.dacid ;";//echo $sql;
$result=$connect->query($sql);	
//echo $sql;
while($row=$result->fetch()){
	$ctr++;
	echo "<TR><TD bgcolor='lightyellow'>$row[0]</TD><TD bgcolor='lightyellow'>$row[1]</TD><TD><a href='lreset.php?id=$row[0]' >[Reset]</a></TD></TR>";
}
echo "<span id=rcount>$ctr</span>";
die();


?>