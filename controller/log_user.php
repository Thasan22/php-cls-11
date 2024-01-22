<?php
session_start();
include_once "../database/env.php";


// $email = $_POST['email'];
// $password = $_POST['password'];

// // Validate the input
// $errors = [];
// if (empty($email)) {
//     $errors['email'] = 'Email is required';
// }
// if (empty($password)) {
//     $errors['password'] = 'Password is required';
// }

// if (empty($errors)) {
//     // Check if the user exists in the database
//     $db = new Database();
//     $user = new User($db);
//     $userByEmail = $user->getByEmail($email);
//     if ($userByEmail && $user->passwordMatches($password, $userByEmail->password)) {
//         // Set the session variables
//         $_SESSION['user'] = $userByEmail;
//         // Redirect the user to the home page
//         header('Location: ../index.php');
//         exit;
//     } else {
//         $errors['login'] = 'Invalid email or password';
//     }
// }

// // Store the errors in the session and redirect the user back to the login page
// $_SESSION['errors'] = $errors;
// header('Location: ../backend/login.php');


$email = $_REQUEST["email"];
$password = $_REQUEST["password"];

// VALIDATION
$errors = [];


// EMAIL & PASSWORD CHECK
$query = "SELECT * FROM users WHERE email = '$email'";
$res = mysqli_query($db_connect,$query);
if(empty($email)){
    $errors['email'] = "Email is required";
}else if($res->num_rows == 0){
    $errors['email'] = "Email Address is incorrect";
}

if(empty($password)){
    $errors['password'] = "Password is required";
}else{
    $db_user = mysqli_fetch_assoc($res); 
    $right_pass = password_verify($password,$db_user['password']);

    if(!$right_pass){
        $errors['password'] = "Password is incorrect";
    }else{
        // redirect to dashboard

        $_SESSION['auth'] = $db_user;

        header("location: ../backend/dashboard.php");
    }
}

// IF ERRORS FOUND
if(count($errors) > 0){
    $_SESSION['errors'] = $errors;
    header('location: ../backend/login.php');
}