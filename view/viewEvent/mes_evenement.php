<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mes événements</title>
  <link rel="stylesheet" href="../../public/css/mes_evenement.css">
</head>
<body>
<div class="container">
  <aside class="sidebar">
    <h2>Paramètres</h2>
    <ul>
      <li><a href="#">Organisation</a></li>
      <li><a href="#">Mon compte</a></li>
    </ul>
  </aside>
  <main class="main-content">
    <section class="profile-section">
      <h1>Mes événements</h1>
      <p>Voici la liste des événements que vous avez créés. Cliquez sur "Modifier" pour mettre à jour un événement.</p>

      <ul class="event-list">
        <li class="event-item">
          <h2>Événement 1</h2>
          <p>Description de l'événement 1</p>
          <button class="btn btn-primary" onclick="location.href='modifier_evenement.html?id=1'">Modifier</button>
        </li>
        <li class="event-item">
          <h2>Événement 2</h2>
          <p>Description de l'événement 2</p>
          <button class="btn btn-primary" onclick="location.href='modifier_evenement.html?id=2'">Modifier</button>
        </li>
        <!-- Ajoutez d'autres événements ici -->
      </ul>
    </section>
  </main>
</div>
</body>
</html>