<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["Név"]);
    $email = htmlspecialchars($_POST["Email"]);
    $program = htmlspecialchars($_POST["Program"]);// A kiválasztott program
    $phone = htmlspecialchars($_POST["Telefonszám"]);
    $message = htmlspecialchars($_POST["Megjegyzés"]);

    
    $mail = new PHPMailer(true);
    $mail->setLanguage('hu', '/phpmailer/language/');
    try {
        // SMTP beállítások
        $mail->isSMTP();
        $mail->Host = 'smtppro.zoho.eu'; // Cseréld le, ha más SMTP-t használsz
        $mail->SMTPAuth = true;
        $mail->Username = 'peterne.tajmel@gmail.com'; // Saját e-mail címed
        $mail->Password = '7iKH5vjw3CnE'; // Gmail esetén alkalmazásjelszó kell!
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Feladó és címzett beállítások
		$mail->CharSet = 'UTF-8'; 
        $mail->setFrom('peterne.tajmel@gmail.com', 'Brigi Dekor&HandMade');
        $mail->addAddress('info@bdhm.hu'); 
        $mail->addReplyTo($email, $name);

        // Email tartalom
        $mail->isHTML(false);
        $mail->Subject = "Új jelentkezés: $name";
        $body = "Név: $name\n";
        $body .= "E-mail cím: $email\n";
        $body .= "Program megnevezése: $program\n"; // Kiválasztott program beillesztése
        if (!empty($phone)) {
            $body .= "Telefonszám: $phone\n";
        }
        if (!empty($message)) {
            $body .= "Megjegyzés:\n$message\n";
        }
        $mail->Body = $body;

        // Küldés
        $mail->send();
        echo "<script>alert('Szuper - Sikeresen elküldve!'); window.location.href='hirek.html';</script>";
    } catch (Exception $e) {
        echo "<script>alert('Hiba történt: " . $mail->ErrorInfo . "'); window.history.back();</script>";
    }
} else {
    header("Location: hirek.html");
    exit();
}
?>
