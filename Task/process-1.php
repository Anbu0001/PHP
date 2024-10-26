<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- <link rel="stylesheet" href="style.css"> -->
</head>
<body>
    <h1>Done</h1>


<?php  
 include("dbcon.php");

 $getdata = isset($_GET['id']);
 $getdata = $_GET['id'];


if($getdata){
    $process1 = mysqli_query($conn,"UPDATE employee_table SET process_stage_1=0 ,  process_stage_2=1 where id=$getdata");
  
    echo "<br> $process1 ";

    // header ("Location:index.php");


    header ("Location:process-2.php");



} else {
    echo "GET Data Error!!!!!!";
};


?>
<!-- \\\\\\\\\\\\\\\\\\\\\\\\=-----------process2-----------------\\\\\\\\\\\\\\\\\\\\\\\\-->
<?php  


 $getdata1 = isset($_GET['process2']);
 $getdata1 = $_GET['process2'];


if($getdata1){
    $process2 = mysqli_query($conn,"UPDATE employee_table SET process_stage_2=0 ,process_stage_3=1  where id=$getdata1");
  
    echo "<br> $process2 ";

    // header ("Location:index.php");


    header ("Location:process-3.php");



} else {
    echo "GET Data Error!!!!!!";
}

?>

<!-- \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\-----------process3---------\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\-->
 
<?php  


 $getdata2 = isset($_GET['process3']);
 $getdata2 = $_GET['process3'];


if($getdata2){
    $process3 = mysqli_query($conn,"UPDATE employee_table SET process_stage_3=0 , process_stage_1=1  where id=$getdata2");
  
    echo "<br> $process3 ";

    header ("Location:index.php");





} else {
    echo "GET Data Error!!!!!!";
}

?>