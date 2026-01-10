<main class="main-content">
    <section class="bts-sio" id="page-content">
        <header class="bts-sio__header">
            <h1><?php echo Security::sanitize($pageData['titre']); ?></h1>
        </header>

        <div class="bts-sio__block">
            <?php echo nl2br(Security::sanitize($pageData['contenu'])); ?>
        </div>
    </section>
</main>

