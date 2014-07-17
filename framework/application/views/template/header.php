<!DOCTYPE html>
<html>
<head>
    <title><?php if(isset($title)){echo $title;}else { echo "Welcome";} ?></title>
    <?php
    echo Asset::container('header')->styles();
    echo Asset::container('header')->scripts();
    ?>
</head>

