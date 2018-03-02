<?php
use \Marvel\Model\MarvelDataModel;
/**
 * Home page for Marvel exercise
 *
 * Ps : template is not made by me, it's html5up => https://html5up.net
 *
 * @author : maher.isnard@gmail.com
 */
require('vendor/autoload.php');
$marvelData = new MarvelDataModel();
$characters = $marvelData->charactersCollection();
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Multiverse by HTML5 UP</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
    <link rel="stylesheet" href="assets/css/main.css" />
    <!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
    <!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
</head>
<body>

<!-- Wrapper -->
<div id="wrapper">

    <!-- Header -->
    <header id="header">
        <h1><a href="index.html"><strong>Isnard Maher</strong> => maher.isnard@gmail.com</a></h1>
        <nav>
            <ul>
                <li><a href="#footer" class="icon fa-info-circle">About</a></li>
            </ul>
        </nav>
    </header>

    <!-- Main -->
    <div id="main">
        <?php foreach ($characters as $character): ?>
        <article class="thumb">
            <a href="<?php echo $character->thumbnail->path . '.'
                . $character->thumbnail->extension; ?>"
               class="image"><img src="<?php echo $character->thumbnail->path . '.' . $character->thumbnail->extension; ?>" alt="" /></a>
            <h2><?php echo $character->name; ?></h2>
            <p>
                <b>Name : <?php echo $character->name; ?></b><br>
                <b>Description : <?php echo strlen($character->description) == 0 ? 'No description available'
                        : $character->description ?></b><br>
                <b>Number of aparition : <?php echo $character->comics->available; ?></b><br>
                <b>Three first commics apparition : <br>
                    <?php
                        $comicsCount = 0;
                        foreach ($character->comics->items as $comics) {
                            echo "- <a href='$comics->resourceURI'>$comics->name</a><br>";
                            $comicsCount++;
                            if ($comicsCount == 3) {
                                break;
                            }
                        }
                    ?>
                </b>
            </p>
        </article>
        <?php endforeach; ?>
    </div>

    <!-- Footer -->
    <footer id="footer" class="panel">
        <div class="inner split">
        </div>
    </footer>

</div>

<!-- Scripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/jquery.poptrox.min.js"></script>
<script src="assets/js/skel.min.js"></script>
<script src="assets/js/util.js"></script>
<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
<script src="assets/js/main.js"></script>

</body>
</html>
