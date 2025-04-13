<?php 
include 'acccon.txt';
include 'chklogin.txt';
?>
<style>

.menu td:hover{
	color: white;
	background-color: #F39C12;
	cursor: pointer;
}
.menu td:hover a:active {color:red;}
</style>
<script>


setInterval(function(){ t(); }, 3000);

function load_assgn(x){
	
	window.location.href = x;
}


function t(){

var xhttp = new XMLHttpRequest();
xhttp.onreadystatechange=function(){
	if (this.readyState == 4 && this.status == 200){
	document.getElementById("demo").innerHTML = this.responseText;
	document.getElementById("rcount1").innerHTML="[Students Loggedin="+document.getElementById("rcount").innerHTML+"]  <a href=lreset.php?id=a>[RESET ALL]</a>";
	}
};
xhttp.open("GET", "ajax_info.php", true);
xhttp.send();
}


</script>

<body style="font-family:Monospace;">
<table width=100%>
<TR>
	<TD width="10%"><?php echo $_SESSION['stdname'];?>, <span style="color:red;">Admin Page</span></TD>
	<TD width="10%" align=right><button onclick="window.location.href = 'logout.php';"> LOGOUT </button></TD>
</TR>
</Table>

<hR color="#F1C40F">
<table width=100%>
<TR bgcolor=black style="background-color:#FCF3CF ;color:black;" class="menu">
	<TD width=10% align=center>HOME</TD>
	<TD width=10%  ><a href='profilelist.php'>GROUP FORMATION</a></TD>
	<TD width=10%  ><a href='projlist.php'>PROJECT LIST</a></TD>
	<TD width=10%  ><a href='prjgrp.php'>PROJECT GROUPS</a></TD>
	<TD></TD>
</TR>
</table>
<hr color="#F1C40F">
<?php
	$stdcount=0;
	$sq="select count(stdid) from students where stdid>1;" ;
	//echo $sq;
	$result=$connect->query($sq);
	if($row=$result->fetch())
		$stdcount=$row[0];
		
?>
<table width="98%" cellspacing=0 border=0>
<TR>
	<TD width=33.33%>
	<table width="40%" cellspacing=0 border=0>
		<TR>
			<TD bgcolor='#F9E79F'>Details</TD>
		</tr>
		<TR bgcolor='#FEF9E7 '>
			<TD>No. of Studetns Enrolled : <?php echo $stdcount; ?></TD>
			
		</TR>
	</table>
	</TD>
</TR>
</table>
<hr color=red>

</body>