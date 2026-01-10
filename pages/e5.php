<?php
// Définir le chemin racine du projet
$rootPath = dirname(__DIR__);
$pageTitle = 'Épreuve E5';
$pageCSS = 'bts.css'; // CSS spécifique à cette page
include $rootPath . '/src/views/includes/header.php';
include $rootPath . '/src/views/includes/sidebar.php';
?>

<main class="main-content">
    <!-- Navigation interne -->
    <nav class="e5-nav">
        <a href="#presentation" class="e5-nav-link">Présentation</a>
        <a href="#tableau" class="e5-nav-link">Tableau de synthèse</a>
        <a href="#powerpoint" class="e5-nav-link">PowerPoint</a>
        <a href="#veille" class="e5-nav-link">Veille</a>
    </nav>

    <!-- Section 1: Présentation Épreuve E5 -->
    <section class="bts-sio" id="presentation">
        <header class="bts-sio__header">
            <h1>Présentation de l'Épreuve E5</h1>
            <p>
                L'épreuve E5 est une épreuve orale qui consiste à présenter un portfolio numérique et à démontrer les compétences acquises lors des missions réalisées en entreprise.
            </p>
        </header>

        <div class="bts-sio__block">
            <h2>Objectifs de l'épreuve</h2>
            <p>
                <!-- À compléter par l'utilisateur -->
                L'épreuve E5 permet d'évaluer les compétences professionnelles acquises lors des périodes de stage en entreprise.
            </p>
        </div>

        <div class="bts-sio__block">
            <h2>Contenu attendu</h2>
            <ul>
                <li>Portfolio numérique présentant les missions réalisées</li>
                <li>Démonstration des compétences techniques et professionnelles</li>
                <li>Tableau de synthèse des compétences</li>
                <li>Présentation orale avec support (PowerPoint)</li>
                <li>Veille technologique</li>
            </ul>
        </div>
    </section>

    <!-- Section 2: Tableau de synthèse -->
    <section class="bts-sio" id="tableau">
        <header class="bts-sio__header">
            <h1>Tableau de synthèse des compétences</h1>
            <p>
                Ce tableau présente les compétences mobilisées lors de mes missions et leur niveau d'acquisition.
            </p>
        </header>

        <div class="bts-sio__block">
            <div class="tableau-container">
                <table class="e5-tableau">
                    <thead>
                        <tr>
                            <th>Compétences</th>
                            <th>Mission 1</th>
                            <th>Mission 2</th>
                            <th>Mission 3</th>
                            <th>Niveau</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Compétence 1</td>
                            <td>✓</td>
                            <td>✓</td>
                            <td>-</td>
                            <td>Acquise</td>
                        </tr>
                        <tr>
                            <td>Compétence 2</td>
                            <td>-</td>
                            <td>✓</td>
                            <td>✓</td>
                            <td>En cours</td>
                        </tr>
                        <!-- À compléter par l'utilisateur -->
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Section 3: PowerPoint soutenance -->
    <section class="bts-sio" id="powerpoint">
        <header class="bts-sio__header">
            <h1>PowerPoint de soutenance</h1>
            <p>
                Support de présentation utilisé lors de l'épreuve orale E5.
            </p>
        </header>

        <div class="bts-sio__block">
            <h2>Présentation</h2>
            <p>
                <!-- À compléter par l'utilisateur -->
                Le PowerPoint de soutenance présente de manière synthétique les missions réalisées, les compétences acquises et les résultats obtenus.
            </p>
        </div>

        <div class="bts-sio__block">
            <h2>Téléchargement</h2>
            <p>
                <!-- Lien vers le fichier PowerPoint à ajouter -->
                <a href="#" class="download-link">
                    <i class="ri-file-ppt-2-line"></i> Télécharger le PowerPoint de soutenance
                </a>
            </p>
        </div>
    </section>

    <!-- Section 4: Ma veille technologique -->
    <section class="bts-sio" id="veille">
        <header class="bts-sio__header">
            <h1>Ma veille technologique</h1>
            <p>
                Veille technologique réalisée dans le cadre de l'épreuve E5 sur les sujets liés à la cybersécurité et au développement web.
            </p>
        </header>

        <div class="bts-sio__block">
            <h1>Les attaques DDoS : une menace toujours d'actualité pour les entreprises</h1>
            
            <h2>1. Introduction</h2>
            <p>
                Les attaques par déni de service distribué, plus connues sous le nom d'attaques DDoS (Distributed Denial of Service), constituent l'une des menaces les plus courantes sur Internet.
                Leur objectif principal est de rendre un service, un site web ou une application indisponible en le surchargeant de requêtes.
            </p>
            <p>
                Contrairement à certaines idées reçues, les attaques DDoS ne sont pas dépassées. Elles touchent encore aujourd'hui de nombreuses entreprises, y compris des organisations de grande taille disposant d'infrastructures solides.
            </p>

            <h2>2. Principe d'une attaque DDoS</h2>
            <p>
                Une attaque DDoS repose sur un principe simple :
                envoyer un volume massif de requêtes vers un serveur afin de saturer ses ressources (bande passante, CPU, mémoire).
            </p>
            <p>On distingue :</p>
            <ul>
                <li><strong>DoS</strong> : attaque menée depuis une seule machine</li>
                <li><strong>DDoS</strong> : attaque menée depuis des centaines ou des milliers de machines</li>
            </ul>
            <div class="image-center">
                <img src="<?php echo $basePath; ?>gallery/dos_ddos.jpg" alt="Principe d'une attaque DDoS">
            </div>
            <p>
                Ces machines sont généralement infectées et regroupées dans un botnet, contrôlé à distance par l'attaquant. Le serveur ciblé ne parvient plus à répondre aux utilisateurs légitimes.
            </p>

            <h2>3. Les principaux types d'attaques DDoS</h2>
            
            <h3>a) Attaques volumétriques</h3>
            <p>
                Elles visent à saturer la bande passante du réseau.
                Exemple : envoi massif de paquets UDP ou ICMP.
            </p>

            <h3>b) Attaques applicatives</h3>
            <p>
                Elles ciblent directement l'application (HTTP, HTTPS).
                Elles imitent des requêtes légitimes afin de surcharger le serveur web.
            </p>

            <h3>c) Attaques par amplification</h3>
            <p>
                L'attaquant exploite des serveurs intermédiaires (DNS, NTP) pour amplifier le trafic envoyé vers la victime, avec très peu de ressources de son côté.
            </p>

            <h2>4. Pourquoi les attaques DDoS sont toujours d'actualité</h2>
            <p>Plusieurs facteurs expliquent la persistance des attaques DDoS :</p>
            <ul>
                <li>Forte dépendance des entreprises aux services en ligne</li>
                <li>Multiplication des objets connectés, souvent mal sécurisés</li>
                <li>Accessibilité d'outils DDoS "clé en main"</li>
                <li>Coût faible pour l'attaquant comparé aux dégâts causés</li>
            </ul>
            <p>
                Les attaques DDoS sont souvent utilisées comme moyen de pression, de sabotage ou de revendication.
            </p>

            <h2>5. Cas concret en entreprise</h2>
            <p>
                Dans le cadre de mon alternance au sein de La Poste, l'entreprise a récemment été confrontée à deux attaques DDoS sur une courte période.
            </p>
            <div class="image-center">
                <img src="<?php echo $basePath; ?>gallery/la_poste.png" alt="Cas concret en entreprise">
            </div>
            <p>Ces attaques ont mis en évidence :</p>
            <ul>
                <li>la réalité de la menace, même pour une grande organisation,</li>
                <li>l'importance de la surveillance du trafic réseau,</li>
                <li>la nécessité de disposer de solutions de protection adaptées.</li>
            </ul>
            <p>
                Ce contexte professionnel confirme que les attaques DDoS ne sont pas uniquement théoriques, mais bien un risque réel pour les infrastructures informatiques actuelles.
            </p>

            <h2>6. Moyens de protection contre les attaques DDoS</h2>
            <p>Les entreprises mettent en place plusieurs mesures pour limiter l'impact des attaques DDoS :</p>
            <ul>
                <li>Pare-feu et filtrage réseau</li>
                <li>Solutions anti-DDoS spécialisées</li>
                <li>Surveillance du trafic en temps réel</li>
                <li>Répartition de charge (load balancing)</li>
                <li>Plans de réponse aux incidents</li>
            </ul>
            <p>
                Aucune solution n'est totalement infaillible, mais une bonne anticipation permet de réduire fortement les impacts.
            </p>

            <h2>7. Conclusion</h2>
            <p>
                Les attaques DDoS restent une menace majeure pour les entreprises, quelle que soit leur taille.
                Faciles à lancer et difficiles à contrer totalement, elles visent avant tout la disponibilité des services, élément critique du système d'information.
            </p>
            <p>
                L'exemple observé en entreprise montre que ces attaques sont toujours d'actualité et qu'elles doivent être prises en compte dans toute stratégie de sécurité informatique.
            </p>
        </div>

        <div class="bts-sio__block">
            <h2>Outils de veille utilisés</h2>
            <ul>
                <li>Feedly</li>
                <li>Twitter / X</li>
                <li>Reddit</li>
                <li>Blogs spécialisés</li>
            </ul>
        </div>
    </section>
</main>

<?php 
$rootPath = dirname(__DIR__);
include $rootPath . '/src/views/includes/footer.php'; 
?>

