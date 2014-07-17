<?php echo render('template.header') ?>
<body id="top" data-spy="scroll" data-target=".navbar" data-offset="50">
<?php echo Section::yield('contentWrapper'); ?>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!--Footer-->
<?php
echo Asset::container('footer')->scripts();
echo Asset::container('footer')->styles();
?>
</body>
</html>