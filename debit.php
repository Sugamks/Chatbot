<?php

// connecting to database
$conn = mysqli_connect("localhost", "root", "", "bot") or die("Database Error");

// getting user message through ajax
$sid = mysqli_real_escape_string($conn, $_POST['text']);

//checking user query to database query
$sql = "INSERT INTO debit_table VALUES('','$sid')";
$run_query = mysqli_query($conn, $sql) or die("Error");
$get_data = mysqli_query($conn,"SELECT id FROM debit_table WHERE sid='$sid'");
// if user query matched to database query we'll show the reply otherwise it go to else statement
if(mysqli_num_rows($get_data) > 0){
    $fetch_data = mysqli_fetch_assoc($get_data);
    $replay = $fetch_data['id'];
    echo $replay;
}else{
    echo "Sorry can't be able to understand you!";
}

?>