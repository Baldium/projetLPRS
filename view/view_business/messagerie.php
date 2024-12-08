<?php

// Non respect de la structure MVC pour raison de complexité de cette features et aide d'internet (videos) plus GPT à certains endroits et template prise sur le net
include_once '../../init.php';
include_once '../../utils/Bdd.php';
require_once '../../utils/flash.php';
display_flash_message();

// Middleware basique 
$user_id = $_SESSION['id_users'];
if (!isset($_SESSION['id_society'])) {
  set_flash_message("Ne jouez pas au hackeur svp !", "error");
  header("Location: ../connexion.php");
  exit;
}

$my_bdd = Bdd::my_bdd();

// Récuperer tout les "contacts"
$req_sql_contacts = "SELECT u.id_users, u.nom, u.prenom, u.mail, u.ref_society FROM users u WHERE u.id_users != ? and u.type = 1";
$req_contact = $my_bdd->prepare($req_sql_contacts);
$req_contact->execute([$user_id]);
$contacts = $req_contact->fetchAll(PDO::FETCH_ASSOC);

// Initialiser $messages
$messages = [];
$contact_info = [];

// Récupérer les messages de la conversation sélectionnée et les informations du contact
if (isset($_GET['contact_id'])) {
    $contact_id = $_GET['contact_id'];

    // Requête SQL complexe faites par GPT
    $sql_messages = "SELECT m.sender_id, m.receiver_id, m.contenu, m.date_time, u.nom, u.prenom
                     FROM message m
                     JOIN users u ON (m.sender_id = u.id_users OR m.receiver_id = u.id_users)
                     WHERE (m.sender_id = :user_id AND m.receiver_id = :contact_id)
                     OR (m.sender_id = :contact_id AND m.receiver_id = :user_id)
                     ORDER BY m.date_time ASC";
    $stmt = $my_bdd->prepare($sql_messages);
    $stmt->execute([':user_id' => $user_id, ':contact_id' => $contact_id]);
    $messages = $stmt->fetchAll();

    // Récupérer les informations du contact (nom, prénom)
    $req_contact_info = $my_bdd->prepare("SELECT nom, prenom FROM users WHERE id_users = ?");
    $req_contact_info->execute([$contact_id]);
    $contact_info = $req_contact_info->fetch(PDO::FETCH_ASSOC);
}
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/css/messagerie.css">
    <title>Messagerie | SchumanConnect</title>
</head>

<body>
    <div class="container">
        <div class="sidebar">
            <div class="sidebar-header">Messagerie</div>
            <ul class="contact-list">
                <?php 
                // Simple foreach pour avoir les infos de l'user je ne connaissais pas les fonctions strtoupper et substr
                foreach ($contacts as $contact): ?>
                    <li class="contact-item">
                        <a href="?contact_id=<?= $contact['id_users'] ?>">
                            <div class="contact-avatar"><?= strtoupper(substr($contact['prenom'], 0, 1)) ?></div>
                            <div>
                                <div class="contact-name"><?= $contact['prenom'] ?> <?= $contact['nom'] ?></div>
                                <div class="contact-last-message">
                                    Dernier message
                                </div>
                            </div>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <div class="sidebar-header"><a href="./accueil_business.php" style="text-decoration: none; color: black" >Retourner à l'accueil</a></div>
        </div>

        <!-- Message Panel -->
        <div class="message-panel">
            <?php if (isset($contact_id)): ?>
                <!-- Message Header -->
                <div class="message-header">
                    <div class="contact-avatar"><?= strtoupper(substr($contact_info['prenom'], 0, 1)) ?></div>
                    <div><?= $contact_info['prenom'] ?> <?= $contact_info['nom'] ?></div>
                </div>

                <!-- Message Content -->
                <div class="message-content" id="message-content">
                  <?php 
                  // Mettre dans une liste le contenu pour pas afficher le message deux fois il s'affiche deux fois je ne sais pas pourquoi 
                  $dejadMessages = [];

                  foreach ($messages as $message): 
                      $messageKey = $message['contenu'] . $message['date_time'];
                      
                      if (!in_array($messageKey, $dejadMessages)) {
                          $dejadMessages[] = $messageKey;  ?>
                          <div class="message <?= ($message['sender_id'] == $user_id) ? 'sent' : 'received' ?>">
                              <div class="message-text">
                                  <?= htmlspecialchars($message['contenu']) ?>
                                  <div class="message-time"><?= date('H:i', strtotime($message['date_time'] . ' +1 hour')) ?></div>
                              </div>
                          </div>
                  <?php } endforeach; ?>
                </div>

                <!-- Message Input -->
                <div class="message-input">
                    <textarea name="message" placeholder="Écrire un message..."></textarea>
                    <button type="button" onclick="sendMessage()">Envoyer</button>
                </div>
            <?php else: ?>
                <div class="no-contact-selected">Veuillez sélectionner un contact pour commencer la conversation.</div>
            <?php endif; ?>
        </div>
    </div>
    

   
    <script>
        // GPT
        window.onload = function() {
            var messageContent = document.getElementById('message-content');
            messageContent.scrollTop = messageContent.scrollHeight;
        };  

        const ws = new WebSocket('ws://127.0.0.1:8080/chat');

        ws.onopen = () => {
            console.log('Connecté au serveur WebSocket');
        };

        ws.onmessage = (event) => {
            const data = JSON.parse(event.data);

            // Ajout du message au DOM
            const messageContent = document.getElementById('message-content');
            const messageElement = document.createElement('div');
            messageElement.className = data.sender_id === <?= $user_id ?> ? 'message sent' : 'message received';
            messageElement.innerHTML = `
                <div class="message-text">
                    ${data.message}
                    <div class="message-time">${data.time}</div>
                </div>
            `;
            
            // Ajout du message dans le contenu des messages
            messageContent.appendChild(messageElement);
            
            // Assurez-vous que l'élément défile vers le bas pour voir le dernier message
            messageContent.scrollTop = messageContent.scrollHeight;
        };

        // Envoyer un message à l'autre utilisateur via WebSocket
        function sendMessage() {
        const messageInput = document.querySelector('textarea[name="message"]');
        const message = messageInput.value.trim();


            // Envoi du message au serveur via WebSocket
            ws.send(JSON.stringify({
                sender_id: <?= $user_id ?>,
                receiver_id: <?= $contact_id ?>,
                message: message,
                time: new Date().toLocaleTimeString()
            }));

            messageInput.value = ''; // Réinitialisation du champ de texte après envoi
        }

    </script>

</body>

</html>
