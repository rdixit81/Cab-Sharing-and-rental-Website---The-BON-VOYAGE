<?php
session_start();
$username= "";
$email="";
$password ="";
$phno="";
$errors= array();
$flag=0;
$con= mysqli_connect("localhost","root","","ebook");
if(isset($_POST['submit']))
{
$username = mysqli_real_escape_string($con,$_POST['username']);
$email = mysqli_real_escape_string($con,$_POST['email']);
$password = mysqli_real_escape_string($con,$_POST['password']);
$phno= mysqli_real_escape_string($con,$_POST['phno']);

if(empty($username)){
    array_push($errors,"username is required");
}
if(empty($phno)){
    array_push($errors,"phone number is required");
}
if(empty($email)){
    array_push($errors,"email is required");
}
if(empty($password)){
    array_push($errors,"password is required");
}
if(count($errors)==0)
{
  $sql="INSERT INTO users (username,email,password,phone) VALUES('$username','$email','$password','$phno')";
  mysqli_query($con,$sql);
  $flag=1;
}
}
if(isset($_POST['login'])){ 
    $errors= array();
    $email = mysqli_real_escape_string($con,$_POST['email']);
    $password= mysqli_real_escape_string($con,$_POST['password']);
    
    if(count($errors)==0)
    {
    $sql="SELECT userid,username FROM users WHERE email='$email' and password='$password'";
    $result=mysqli_query($con,$sql);
    if(mysqli_num_rows($result)==1){
        $row=mysqli_fetch_array($result);
        $_SESSION['userid']=$row[0];
        $_SESSION['users']=$row[1];
        $date=date("Y-m-d");
        $sql="INSERT INTO visitor (userid,date) VALUES('$row[0]','$date')";
        mysqli_query($con,$sql);
      
    }
    else{
        array_push($errors,"incorrect username/password");
        echo "<script> alert('incorrect username/password')</script>";
    } 
    }
    }
?>