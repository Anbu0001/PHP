<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
</body>
</html>

<?php 

include("dbcon.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $age = $_POST['age'];
        $process1 = $_POST['process1'];
        $process2 = $_POST['process2'];
        $process3 = $_POST['process3'];
        $main_status=1;

        $sqlstatement = mysqli_query($conn,"INSERT INTO employee_table (
        username,
        userage,
         process_stage_1,
         process_stage_2,	
         process_stage_3,		
         main_status
         ) 
         VALUES 
         (
         '$name',
          $age,
         '$process1',
         '$process2',
         '$process3',
          $main_status
         )"
        );
        

    
    }

?>

   <table >
    <tr >
        <th>S.no</th>
        <th>Name</th>
        <th>Age</th>
        <th>Action</th>
    </tr>
    <?php  
    $i=1;
    $process1 = mysqli_query($conn,"SELECT * FROM employee_table where process_stage_1=0 && process_stage_2=1");
    while($getdata=mysqli_fetch_array($process1)){
 

   ?>
    <tr>
    <td>
            <?php echo $i?>
        </td>
        <td>
            <?php echo $getdata["username"] ?>
        </td>
        <td>
            <?php echo $getdata["userage"] ?>
            </td>

            <td>
                <a href="process-1.php?process2=<?php echo $getdata['id']; ?>">Move</a>
            </td>

 
        
        
        <?php $i++; }

?>
       
        <?php 
   " </tr>
   </table>"

   ?>





