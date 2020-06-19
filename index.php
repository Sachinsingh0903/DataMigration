<!DOCTYPE html>
<html>
<head>
	<title>DATA-MIGRATION</title>
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
<body><CENTER>
<H1>DETAILS THAT IS UPLOADED</H1>
</CENTER>

</body>
</html>



<?php 

require 'Classes/PHPExcel/IOFactory.php';

    $host = "localhost";
	$user = "root";
	$password = "";
	$db_name = "mytable";
	 
 
 if (isset($_POST['submit'])) 
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
</head>
<body>
	<form action="" method="POST" enctype="multipart/form-data">
		 
			 
			<input type="file" name="file" >
			<input type="submit"  name="submit" value="upload">
		 
	</form>
</body>
</html>
