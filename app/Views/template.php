<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="<?= SITE_URL ?>assets/favicons/favicon-48x48.png" sizes="48x48" />
    <link rel="icon" type="image/svg+xml" href="<?= SITE_URL ?>assets/favicons/favicon.svg" />
    <link rel="shortcut icon" href="<?= SITE_URL ?>assets/favicons/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="<?= SITE_URL ?>assets/favicons/apple-touch-icon.png" />
    <link rel="manifest" href="<?= SITE_URL ?>assets/favicons/site.webmanifest" />
    <link rel="stylesheet" href="https://bootswatch.com/5/journal/bootstrap.min.css">
    <link rel="stylesheet" href="<?= SITE_URL ?>assets/css/styles.css">
    <script src="<?= SITE_URL ?>assets/js/main.js" defer></script>
    <title>Biblio | <?= $titre; ?></title>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/"><img src="<?=SITE_URL ?>logo.png" alt=""></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarColor01">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="/">Home
                            <span class="visually-hidden">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= SITE_URL ?>livres">Livres</a>
                    </li>
                    <?php if (array_key_exists('utilisateur', $_SESSION) && $_SESSION['utilisateur']['role'] === 'ROLE_ADMIN') : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= SITE_URL ?>gestion-membres">Gestion membres</a>
                        </li>
                    <?php endif; ?>
                    <?php if (!array_key_exists('utilisateur', $_SESSION)) : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= SITE_URL ?>connexion">Connection</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= SITE_URL ?>inscription">Inscription</a>
                        </li>
                    <?php elseif (array_key_exists('utilisateur', $_SESSION) && $_SESSION['utilisateur']['is_valide']) : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= SITE_URL ?>deconnexion">Déconnexion</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= SITE_URL ?>profil">Profil</a>
                        </li>
                    <?php endif; ?>

                </ul>
            </div>
        </div>
    </nav>
    <div id="container" class="m-2">
        <h1 class="rounded border border-dark p-2 text-center text-white bg-info"><?= $titre ?></h1>
        <?= $content ?>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>