<?php
/*
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//inclusion des fichiers nécessaires au fonctionnement de PHPMailer
//require __DIR__ . '/../phpmailer/src/Exception.php';
require __DIR__ . '/../phpmailer/src/PHPMailer.php';
require __DIR__ . '/../phpmailer/src/SMTP.php';

function sendResetEmail($toEmail, $resetLink)
{
    $mail = new PHPMailer(true);

    try {
        // === Config SMTP (Gmail) ===
        $mail->CharSet = 'UTF-8';
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;

        // Pour tester, mets ici ton adresse Gmail + un mot de passe d’application (à générer sur ton compte gmail)
        $mail->Username   = 'monadressemail@gmail.com'; //adresse mail à configurer avec le version finale pour la soutenance
        $mail->Password   = 'XXXX XXXX XXXX XXXX'; //ceci sera le mdp à configurer sur le compte de l'application

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Expéditeur / destinataire
        $mail->setFrom('monadressemail@gmail.com', 'MedInfo');
        $mail->addAddress($toEmail);

        // Contenu
        $mail->isHTML(true);
        $mail->Subject = 'Réinitialisation de votre mot de passe MedInfo';

        $mail->Body = '
            <p>Bonjour,</p>
            <p>Vous avez demandé la réinitialisation de votre mot de passe sur <strong>MedInfo</strong>.</p>
            <p>Cliquez sur le bouton ci-dessous pour choisir un nouveau mot de passe :</p>
            <p style="text-align:center; margin: 24px 0;">
                <a href="' . htmlspecialchars($resetLink) . '" 
                   style="
                        display:inline-block;
                        padding:12px 20px;
                        border-radius:999px;
                        background-color:#4D61F4;
                        color:#ffffff;
                        text-decoration:none;
                        font-weight:600;
                        font-family:Arial, sans-serif;">
                    Réinitialiser mon mot de passe
                </a>
            </p>
            <p>Ce lien est valable pendant 1 heure.</p>
            <p>Si vous n\'êtes pas à l\'origine de cette demande, vous pouvez ignorer cet e-mail.</p>
            <p>Cordialement,<br>L\'équipe MedInfo</p>
        ';

        $mail->AltBody = "Bonjour,\n\n".
                         "Vous avez demandé la réinitialisation de votre mot de passe MedInfo.\n\n".
                         "Utilisez ce lien pour choisir un nouveau mot de passe :\n" . $resetLink . "\n\n".
                         "Ce lien est valable pendant 1 heure.\n\n".
                         "Si vous n'êtes pas à l'origine de cette demande, ignorez cet e-mail.\n";

        $mail->send();
        return true;

    } catch (Exception $e) {
        // En cas de problème, decommenter cette ligne pour le débug
        //error_log('Erreur envoi mail reset : ' . $mail->ErrorInfo);
        return false;
    }
}
*/