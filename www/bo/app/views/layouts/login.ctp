<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title>Administration</title>
    <link rel="icon" href="<?php echo $this->base.'/../favicon.ico' ?>" type="image/x-icon" />
    <link rel="shortcut icon" href="<?php echo $this->base.'/../favicon.ico' ?>" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="<?php echo $this->base?>/css/style.css?<?php echo date('YmdH') ?>"/>

    <?php
    echo $javascript->link('jquery');
    echo $javascript->link('prototype');
    echo $javascript->link('scriptaculous');
    ?>

    <script type="text/javascript" src="<?php echo $this->base ?>/js/closure-compiler/"></script>

    <?php echo $scripts_for_layout ?>
</head>
<body class="loginContainer" onload="document.getElementById('UserUsername').focus();">
<div class="bo_login">
    <div class="bo_logo"><?php echo $html->image('logo.png') ?></div>
    <?php
    if ($session->check('Message.flash')) $session->flash();
    ?>
    <div class="bo_content">
        <?php
        echo $content_for_layout;
        ?>
    </div>
</div>

<?php
echo $javascript->link('prototype');
echo $javascript->link('scriptaculous');
echo $javascript->link('effects');
?>
</body>
</html>
