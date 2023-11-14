<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


include 'config.php';

$captcha = $_POST['g-recaptcha-response'];
if($captcha){
 $name = $_POST['name'];
             $email = $_POST['email'];
             $phone = $_POST['phone'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {



             $servername = "localhost";
             $username = $formdatabasename_username;
             $password = $formdatabasename_password;
             $dbname = $formdatabasename;

             
             $conn = new mysqli($servername, $username, $password, $dbname);

             if ($conn->connect_error) {
                
                 die("Connection failed: " . $conn->connect_error);
                 $dbSuccess = false;
             } else{
                
                //  local
                 $sql = "INSERT INTO $formdatabasename_table (name, email, phone) VALUES (?, ?, ?)";

                 $stmt = $conn->prepare($sql);
                 $stmt->bind_param("sss", $name, $email, $phone);
                 $stmt->execute();

                 // Close statement and connection
                 $stmt->close();
                 $conn->close();

                 $dbSuccess = true;  

             }    
}
}
?>


<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Load Composer's autoloader
    require 'PHPMailer/Exception.php';
    require 'PHPMailer/PHPMailer.php';
    require 'PHPMailer/SMTP.php';

    // Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    // Extract POST data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    try {
        $mail->isSMTP();
        $mail->Host = 'localhost';
        $mail->SMTPAuth = true;
        $mail->SMTPAutoTLS = true;
        $mail->Port = 25;
        $mail->Username = $emailSMTPUsername;
        $mail->Password = $emailSMTPPassword;

        $mail->IsSendmail();

        // $mail->SMTPDebug = 0; // Set to 0 for production

        // $mail->addReplyTo($email, $name);
        // $mail->setFrom($receiveEmailFrom, $name);
        // $mail->addAddress($receiveEmailOn, 'asffrrr');
        // $mail->addAddress($receiveEmailOn);

         $mail->From = $receiveEmailFrom;
        $mail->FromName = $name;
        $mail->AddAddress($receiveEmailOn1);
         $mail->addBCC($receiveEmailOn2);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'New Lead from Website by ' . $name;
        $mail->Body = '
        <html>
        <head>
            <title>New Lead</title>
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Salsa&display=swap" rel="stylesheet">
            <style>
                @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Salsa&display=swap");
                h2{
                    font-family: "Salsa", cursive;
                }
                td{
                    font-family: "Montserrat", sans-serif;
                }
            </style>
        </head>
        <body>
            <h2 style="color:#c01d25;font-weight:700;">New Lead Received from Website!!!</h2>
            <table style="width: 40%; border-collapse: collapse; border: 1px solid #000;">
        <tr>
            <td style="font-size: 17px; background-color: #e7de07; color:#c01d25; border: 1px solid darkgrey; padding: 6px 10px;"><strong>Name:</strong></td>
            <td style="font-size: 17px; background-color: #e7de07; color:#c01d25; border: 1px solid darkgrey; padding: 6px 10px; font-weight: bold;">'.$name.'</td>
        </tr>
        <tr>
            <td style="font-size: 17px; background-color: #e7de07; color:#c01d25; border: 1px solid darkgrey; padding: 6px 10px;"><strong>Email:</strong></td>
            <td style=" font-size: 17px; background-color: #e7de07; color:#c01d25 !important; border: 1px solid darkgrey; padding: 6px 10px; font-weight: bold;"><a href="mailto:'.$email.'" style="text-decoration: underline; color:#c01d25 !important;">'.$email.'</a></td>
        </tr>
        <tr>
            <td style="font-size: 17px; background-color: #e7de07;  color:#c01d25; border: 1px solid darkgrey; padding: 6px 10px;"><strong>Phone:</strong></td>
            <td style="font-weight: bold; font-size: 17px; background-color: #e7de07; color:#c01d25 !important; border: 1px solid darkgrey; padding: 6px 10px;"><a href="tel:'.$phone.'" style="text-decoration: none; color:#c01d25 !important;">'.$phone.'</a></td>
        </tr>
    </table>
        </body>
        </html><br>';
        


        // Send the email
        if ($mail->Send()) {
            $emailSuccess = true;
        } else {
            echo "Mail Not Sent";
        }
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: " . $e->getMessage();
    }
}

// Prepare response
$response = array(
    'dbSuccess' => $dbSuccess,
    'emailSuccess' => $emailSuccess
);

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);

?>