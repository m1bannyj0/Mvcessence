<?php
require_once "partials/header.php";
require_once "partials/navbar-home.php";
?>
<main>
    <?php
    if ($notify) require_once "partials/success-message.php";
    require_once "partials/sections/essences-list-section.php";
    ?>
</main>
<?php require_once "partials/footer.php";