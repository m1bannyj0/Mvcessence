<?php
require_once "../Views/header.php";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    echo "You've submitted the form.";
}
require_once "../Views/essence_form.php";
require_once "../Views/footer.php";





