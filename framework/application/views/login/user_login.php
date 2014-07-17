<?php echo Section::start('contentWrapper') ?>
    <form action="<?php echo URL::to_action('login@UserCredential'); ?>" method="post">
        <input type="text"  name="username"  />
        <input type="password" name="password"/>
        <input type="submit" name="submit" value="Login"/>
    </form>
<?php Section::stop(); ?>
<?php echo render('template.main'); ?>