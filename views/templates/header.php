<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/7194bdd5cb.js" crossorigin="anonymous"></script>
    <link rel="icon" type="image/x-icon" href="/../../public/assets/img/logo.svg">
    <link rel="stylesheet" href="../../public/assets/css/main.css">
    <link rel="stylesheet" media="" href="../../public/assets/css/mobile.css">
    <link rel="stylesheet" href="../../public/assets/css/desktop.css">
    <?= isset($isOnMenu) ? '<link rel="stylesheet" href="../../public/assets/css/menu.css">' : ''; ?>
    <?= isset($isOnReview) ? '<link rel="stylesheet" href="../../public/assets/css/review.css">' : ''; ?>
    <?= isset($isOnGalery) ? '<link rel="stylesheet" href="../../public/assets/css/galery.css">' : ''; ?>
    <meta name="description" content="Découvrez la cuisine authentique de L'adresse, notre restaurant italien situé au cœur d'Amiens. Nous proposons une large sélection de plats traditionnels préparés avec les meilleurs ingrédients frais. Réservez une table aujourd'hui pour goûter à notre délicieuse cuisine italienne.">
    <title>Amiens Traiteur</title>
</head>
<body>
    <!-- Header -->

    <header>
        <nav class="flexCenterBetween">
            <div class="containerLogo flexCenterVertical">
                <h3>Amiens Traiteur</h3>
            </div>
            
            <!-- Navbar for desktop view -->
                <div class="desktopNav flexCenterBetween">
                    <a href="/">Accueil</a>
                    <a href="/menus">Menus</a>
                    <a href="/galerie">Galerie</a>
                    <a href="/contact">Contact</a>
                </div>

            <!-- Burger Menu for mobile view -->

                <div class="mobileNav">
                    <a class="openModal" href="#"><span class="containerBurger"></span></a>
                    <ul class="mobileNavList flexCenterCenterColumn">
                        <li class="flexCenterCenter">
                            <a href="/menus" class="createAccount">Menus</a>
                        </li>
                        <li class="flexCenterCenter">
                            <a href="/galerie" class="connectionAccount">Galerie</a>
                        </li>
                        <li class="flexCenterCenter">
                            <a href="/contact" class="connectionAccount">Contact</a>
                        </li>
                    </ul>
                </div>
        </nav>

        <!-- Products image for each size of screen -->

        <div class="heroBanner flexCenterColumn">
            <div class="containerTitle flexCenterCenter">
                <h1>Traiteur sur amiens et ses alentours</h1>
            </div>
            <div class="containerImg flexCenterCenter">
                
            </div>
        </div>

        <!-- Call to action -->

        <div class="footerBanner flexCenterCenter">
            <a href="#pricing" class="callToAction">Découvrez nos menus</a>
        </div>
    </header>
    <main>