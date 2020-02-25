<?php

$conn = mysqli_connect('localhost','root','','patientdatabase');

if (isset($_POST['submit_btn'])) {

  $sql = "SELECT * FROM users WHERE firstname = '".$_POST["firstname"]."'";

  $result = $conn->query($sql);

      if ($result->num_rows > 0) {

        echo "Sorry, user is already in the database!";

      }else{

            $sql = "INSERT INTO patients(firstname,lastname,age,home_address,postalCode,email_address,phone_number,gender,password) VALUES('".$_POST["firstname"]."','".$_POST["lastname"]."','".$_POST["age"]."','".$_POST["home_address"]."','". $_POST["postalCode"]."','".$_POST["email_address"]."','".$_POST["phone_number"]."','".$_POST["gender"]."','".$_POST["password"]."')";

            if ($conn->query($sql) === TRUE) {

                echo"You have sucessfully registered!";

            }
            else {

                echo"Something went wrong";

            }

            $conn->close();
      }

}

 ?>
