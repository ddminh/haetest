<?php
session_start();
// connect to database
$hostName = 'localhost';
$userName = 'root';
$passWord = '';
$databaseName = 'haetest';
$connect = mysqli_connect($hostName, $userName, $passWord, $databaseName);
if (!$connect) {
    exit('Can not connect to database!');
}

function postMessage() { 
    global $connect;
    $result = 1;
    $errorMessage = '';
    $name    = $_GET['name'];
    $email   = $_GET['email'];
    $message = $_GET['message'];
    $date    = date('Y-m-d h:i:s', time());
    // Insert the message to database
    $sql = "INSERT INTO messages(`name`, `email`, `message`, `created_at`) 
        VALUES ('$name', '$email', '$message', '$date')";
 
    if ($connect->query($sql) === TRUE) {
        $result = 1;
    } else {
        $errorMessage = $connect->error;
        $result = 0;
    }

    $res = array('result'=>$result, 'errorMessage' => $errorMessage);
    $connect->close();
    echo json_encode($res);
}

function login() {
     $_SESSION["loggedin"] = FALSE;
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === TRUE){
        header("location: index.php");
        exit;
    }
    global $connect;
    $result = 1;
    $errorMessage = '';
    if ( !isset($_POST['username'], $_POST['password']) ) {
	$result = 0;
	$errorMessage = 'Please fill both the username and password field!';
    }
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $sql = "SELECT * FROM users WHERE name = '$username' LIMIT 1";
    $res = $connect->query($sql);
    $row = array();
    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
    } else {
        $result = 0;
	$errorMessage = 'Username is invalid';
    }
    if(password_verify($password, $row['password'])) {
        $_SESSION['loggedin'] = TRUE;
        $_SESSION['username'] = $row['name'];
        $_SESSION['id'] = $row['id'];
        
    } else {
        $result = 0;
	$errorMessage = 'Incorrect password';
    }
    $return = array('result' => $result, 'errorMessage' => $errorMessage);
    $connect->close();
    echo json_encode($return);
}

function logout() {
    $_SESSION['loggedin'] = FALSE;
    $_SESSION['username'] = 'undefine';
    $_SESSION['id'] = 'undefined';
    header("location: ../index.php");
}

function editMessage() {
    global $connect;
    $result = 1;
    $errorMessage = '';
    $id = $_GET['id'];
    $message = $_GET['message'];
    $sql = "UPDATE messages SET message = '$message' WHERE id = $id";
    if ($connect->query($sql) === TRUE) {
        $result = 1;
    } else {
        $errorMessage = $connect->error;
        $result = 0;
    }
    $res = array('result'=>$result, 'errorMessage' => $errorMessage);
    $connect->close();
    echo json_encode($res);
}

function deleteMessage() {
    global $connect;
    $result = 1;
    $errorMessage = '';
    $id = $_GET['id'];
    $sql = "UPDATE messages SET status = 'deleted' WHERE id = $id";
    if ($connect->query($sql) === TRUE) {
        $result = 1;
    } else {
        $errorMessage = $connect->error;
        $result = 0;
    }
    $res = array('result'=>$result, 'errorMessage' => $errorMessage);
    $connect->close();
    echo json_encode($res);
}

switch($_GET['action']) {
    case 'postMessage': 
        postMessage(); 
        break;
    
    case 'login': 
        login();
        break;
    
    case 'logout': 
        logout(); 
        break;
    
    case 'editMessage':
        editMessage();
        break;
    
    case 'deleteMessage':
        deleteMessage();
        break;
    
    default:
        break;
}

?>
