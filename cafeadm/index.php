<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <link rel="stylesheet" href="assets/css/boot.css"/>
    <link rel="stylesheet" href="assets/css/styles.css"/>
    <link rel="stylesheet" href="assets/css/login.css"/>

    <link rel="icon" type="image/png" href="assets/images/favicon.png"/>

    <title>CaféAdmin - FSPHP Site Control</title>
</head>
<body>

<div class="ajax_load">
    <div class="ajax_load_box">
        <div class="ajax_load_box_circle"></div>
        <p class="ajax_load_box_title">Aguarde, carregando...</p>
    </div>
</div>

<?php
$getApp = filter_input(INPUT_GET, "app", FILTER_SANITIZE_STRIPPED);

if (!empty($getApp)) {
    header("Location: dash.php?app={$getApp}");
} else {
    require __DIR__ . "/widgets/login/login.php";
}
?>

</body>
</html>
