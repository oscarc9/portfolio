<?php
$pageTitle = 'Présentation personnelle';
$pageCSS = 'bts.css'; // CSS spécifique à cette page
include '../../src/views/includes/header.php';
include '../../src/views/includes/sidebar.php';
?>

<main class="main-content">
<section class="bts-sio" id="presentation-personnelle">
  <header class="bts-sio__header">
    <h1>Mon profil</h1>
    <p>
      Je m’appelle <strong>Oscar</strong>, étudiant en <strong>BTS SIO option SLAM</strong>.
      Au fil de la formation, je me suis orienté vers ce qui m’attire le plus : la <strong>cybersécurité</strong>.
    </p>
  </header>

  <div class="bts-sio__block">
    <h2>Présentation personnelle</h2>
    <p>
      J’ai choisi l’informatique parce que j’aime comprendre comment fonctionnent les systèmes et comment ils peuvent être
      protégés. Même si je fais du développement dans le cadre du BTS, je le vois surtout comme un <strong>outil</strong>
      utile en cybersécurité : comprendre le code permet de mieux repérer les failles et les mauvaises pratiques.
    </p>
    <p>
      Ce qui me motive, c’est le côté <strong>analytique</strong> : identifier un problème, le reproduire, comprendre
      pourquoi il existe, puis proposer une solution propre.
    </p>
  </div>

  <div class="bts-sio__block">
    <h2>Ce qui m’intéresse en cybersécurité</h2>
    <ul>
      <li>Comprendre les attaques courantes (ex : injection, XSS, mauvaise gestion des sessions)</li>
      <li>Améliorer la sécurité d’un site ou d’une application (validation, contrôle d’accès, bonnes pratiques)</li>
      <li>Analyser des comportements suspects et exploiter des logs pour détecter un incident</li>
      <li>Approfondir les bases réseau (ports, services, protocoles, exposition)</li>
    </ul>
  </div>

  <div class="bts-sio__block">
    <h2>Objectif</h2>
    <p>
      Mon objectif est de continuer après le BTS dans une voie orientée <strong>cybersécurité</strong> (défense, analyse,
      audit/pentest selon l’opportunité). Ce portfolio me permet de montrer mon évolution, mes compétences, et les projets
      sur lesquels j’ai travaillé, en gardant une approche claire et professionnelle.
    </p>
  </div>
</section>

<section class="bts-sio" id="carte">
  <header class="bts-sio__header">
    <h1>Ma localisation</h1>
    <p>
      Je me trouve à <strong>Strasbourg, 4 rue d'Upsal</strong>.
    </p>
  </header>

  <div class="bts-sio__block">
    <h2>Carte de localisation</h2>
    <div class="map-container">
      <iframe 
        src="https://www.google.com/maps?q=4+rue+d%27Upsal,+67000+Strasbourg&output=embed"
        width="100%" 
        height="450" 
        style="border:0; border-radius: 8px;" 
        allowfullscreen="" 
        loading="lazy" 
        referrerpolicy="no-referrer-when-downgrade"
        title="Carte de localisation - 4 rue d'Upsal, Strasbourg">
      </iframe>
    </div>
    <p style="margin-top: 1rem; color: #b0b0b0;">
      <i class="ri-map-pin-line"></i> 4 rue d'Upsal, 67000 Strasbourg, France
    </p>
  </div>
</section>
</main>

<?php include '../../src/views/includes/footer.php'; ?>
