<?php
$path_prefix = (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? '../' : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo isset($page_title) ? $page_title : 'Delight Home - Premium Homeware & Kitchenware'; ?></title>

    <link rel="stylesheet" href="<?php echo $path_prefix; ?>css/style.css">
    <link rel="stylesheet" href="<?php echo $path_prefix; ?>css/delight-theme.css?v=20261007-17">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>