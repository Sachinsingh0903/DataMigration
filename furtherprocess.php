<!DOCTYPE html>
<html>
<head>
	<title>DETAILS</title>
	<style type="text/css">
		body{
			background: yellow;
		}
		
		h1{
			text-align: center;
			color: green;
			}
		table{
				border: 1px solid black;
				width: 100%
				height:100%;
			}
		th,td{
			background:lightgreen;
			border: 1px solid black;
			font-size: 30px;
			text-align: center;
			width: 50px;
			height:50px; 
		}
	</style>
</head>

<body></html>



<?php 

require 'Classes/PHPExcel/IOFactory.php';

    $host = "localhost";
	$user = "root";
	$password = "";
	$db_name = "mytable";
	 
 
 if (isset($_POST['upload'])) 
{
	 	# code...
	$inputfilename=$_FILES['file']['tmp_name'];
	$exceldata=array();

	 $conn = mysqli_connect($host,$user,$password,$db_name);
	  //if($conn)
	  	//echo "connection successful";
	  //else
	  	//echo "failed";
	 

try
{
	$inputfiletype=PHPExcel_IOFactory::identify($inputfilename);
	$objReader=PHPExcel_IOFactory::createReader($inputfiletype);
	$objPHPExcel=$objReader->load($inputfilename);
}
catch(Exception $e)
{
	die('Error loading file "'.pathinfo($inputfilename,PATHINFO_BASENAME).'";'.$e->getMessage());
}


$sheet=$objPHPExcel->getSheet(0);
$highestRow=$sheet->getHighestRow();
$highestColumn=$sheet->getHighestColumn();
$attr=array();
for ($row = 1; $row <= 1; $row++) 
{
	$rowData=$sheet->rangeToArray('A'.$row.':'.$highestColumn.$row, NULL, TRUE, FALSE);
	for ($col=1; $col <=$highestColumn ; $col++) 
	{ 
		
array_push($attr,$rowData[0][$col]);
print_r($attr);
	}
}



for ($row = 2; $row <= $highestRow; $row++) 
{ 
	$rowData=$sheet->rangeToArray('A'.$row.':'.$highestColumn.$row, NULL, TRUE, FALSE);

	$sql="INSERT INTO excel_data (first_name,Last_name,email) VALUES ('".$rowData[0][0]."','".$rowData[0][1]."','".$rowData[0][2]."')";
		if(mysqli_query($conn,$sql)){
			$exceldata[] =$rowData[0];
		}
		else
		{
			echo "Error" .$sql. "<br>".mysql_error($conn);
		}
 }



 // $db=array();
 // $cm=array();
$tablesnames=array();


$dsql="SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='mytable'";
$db =mysqli_query($conn,$dsql);
while($row=mysqli_fetch_array($db))
{
	array_push($tablesnames, $row["TABLE_NAME"]);	
}

foreach ($tablesnames as $index => $value) {


	$csql="SELECT COLUMN_NAME FROM information_schema.columns WHERE table_schema='mytable' AND table_name='".$value."';";

	 $cm=mysqli_query($conn,$csql);
	 $columnname=array();

	while ($col=mysqli_fetch_array($cm)) {
		# code...

		array_push($columnname, $col["COLUMN_NAME"]);
		for($i=1;$i<=sizeof($attr);$i++){
		if($col["COLUMN_NAME"]==$attr[$i]){
		for ($row = 2; $row <= $highestRow; $row++) 
{ 
	$rowData=$sheet->rangeToArray('A'.$row.':'.$highestColumn.$row, NULL, TRUE, FALSE);

	$sql="INSERT INTO excel_data (first_name,Last_name,email) VALUES ('".$rowData[0][0]."','".$rowData[0][1]."','".$rowData[0][2]."')";
		if(mysqli_query($conn,$sql)){
			$exceldata[] =$rowData[0];
		}
		else
		{
			echo "Error" .$sql. "<br>".mysql_error($conn);
		}
 }

			}

		}
	}

}



echo "<center> <table >";
foreach ($exceldata as $index => $excelrow)
 {
	echo "<tr>";
	foreach ($excelrow as $excelcolumn)
	 {
		echo "<td>".$excelcolumn."</td>";
	}
	echo "</tr>";
}
echo "</table></center>";
mysqli_close($conn);
}
?> 






<html>
<head>
	<title>DataMigration</title>
	<style type="text/css">

#header{
text-align: center;
		}
		.zs{
			font-size: 30px;
		}

		.form1{
			background: yellow;
			font-size: 50px;
			text-align: center;
			margin: 0 auto;
			height: 100%;
			width: 100%;
		}
		#post{
			background: blue;
			padding: 3px;
			color: #fff;
		}
		.wrapper{
			width: 100%;
			font-size: 45px;
			background: green;
			height: 55px;
			text-align: right;
		}
		.marquee{
			white-space: nowrap;
			-webkit-animation:rightThenLeft 4s linear;
		}
	</style>
</head>
<body>
	<div class="form1">
	<form action="index.php" method="POST" enctype="multipart/form-data">
		 
			 <h3>DATA MIGRATION</h3>
			 <div class="wrapper">
			 	<marquee behaviour="alternate"><span class="marquee">
			 	Choose a spreadsheet to insert into a database. The spreadsheet contain data that can be easily insert into database. 
			 </span></marquee></div>
			
			<br><br>
			<input class="zs" type="file" name="file" >
			<input class="zs" type="submit"  name="upload" value="upload">
		 <br>
	</form>
	</div>
</body>
</html>
