<?php 
include('connection.php');
$sql = "insert into tanda_tangan(page,x,y,orientation) values('$_POST[page]','$_POST[x]','$_POST[x]','$_POST[orientation]')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
header('location:index.php');