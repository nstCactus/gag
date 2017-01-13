<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title><?php echo $title_for_layout?></title>
    <link rel="shortcut icon" href="<?php echo $this->base?>/favicon.ico" type="image/x-icon"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->base?>/css/style.css?<?php echo date('YmdH') ?>"/>
    <?php
    echo $javascript->link('jquery');
    echo $javascript->link('prototype');
    echo $javascript->link('scriptaculous');
    ?>
    <style type="text/css">
        .inlineblock {display: -moz-inline-stack;display: inline-block;vertical-align: middle;}
    </style>
    <!--[if lte IE 7]>
    <style type="text/css">
        .inlineblock {display: inline;zoom: 1;}
    </style>
    <![endif]-->
    <script type="text/javascript" src="<?php echo $this->base ?>/js/closure-compiler/?<?php echo date('YmdH') ?>"></script>
    <?php echo $scripts_for_layout ?>
</head>
<body id="body">
<div id="bo_main_container">
    <div class="bo_header">
        <div class="bo_auth">
            <div class="bo_logo"><a href="<?php echo $this->base ?>"><?php echo $html->image('logoLite.png')
                    ?></a></div>
            <ul class="bo_header_list">
                <?php if(isset($user)): ?>
                    <li>
                        <div class="bo_logout">
                            <?php
                            echo $html->link(
                                __("Déconnexion", true),
                                array('controller' => 'users', 'action' => 'logout'),
                                array(),
                                __("Êtes-vous sûr de vouloir quitter le Back Office?", true),
                                false);
                            ?>
                        </div>
                    </li>
                    <li>
                        <div class="bo_user_online <?php if(Acl::checkAco('controllers')): ?>bo_user_online_super<?php endif; ?>">
                            <?php
                            if(empty($user["firstname"]) && empty($user["name"])){
                                $displayedName = $user["username"];
                            } else {
                                $displayedName = ucfirst($user["firstname"]).' '.ucfirst($user["name"]);
                            }
                            ?>
                            <?php echo $html->link($displayedName,array('controller' => 'users', 'action' => 'edit_self'),array(),null,false); ?>
                        </div>
                    </li>
                <?php endif ?>
                <li class="first">
                    <?php
                    $url = Configure::read('Config.httpWebroot');
                    if(empty($url))
                    {
                        $url = $this->base;
                        $url = preg_replace('#/bo$#', '/',$url);
                        echo '<a href="'.$url.'" target="_blank">'.__('Accéder au site',1).'</a>';
                    }
                    else
                    {
                        echo $html->link(__('Accéder au site',1), $url, array('target' => '_blank'));
                    }
                    ?>
                </li>
            </ul>
        </div>
        <div class="bo_menu">
            <div class="bo_menu_inner">
                <div class="menuDropdown">
                    <div class="menuTitle">
                        <?php
                        $url = array('controller' => 'pages', 'action' => 'index');
                        echo $html->link(__("Menu", 1), "#", array('class'=>'inlineblock'));
                        ?>
                    </div>
                    <div class="dropdown">
                        <?php  echo $this->element('menu'); ?>
                    </div>
                </div>
                <div class="bo_navig">
                    <?php echo $crumb->toString($breadcrumb) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="bo_container" id="bo_container">
        <div class="bo_content">
            <?php
            if ($session->check('Message.flash')) {
                $session->flash();
            }
            echo $content_for_layout;
            ?>
        </div>
    </div>
    <div class="bo_footer" id="bo_footer">
        <div class="bo_footer_inner">
            <div class="bo_footer_content">
                <?php if(Configure::read('debug') != 0):?>
                    <div class="debugBox debugHidden" id="debugBox">
                        <div class="debugStatut"><?php echo sprintf(__('Debug activé (debug = %s)',1), Configure::read('debug')) ?></div>
                        <?php if(Configure::read('debug') == 2):?>
                            <div class="sep"> / </div>
                            <a href="#" class="debugSwitch" id="debugSwitchShow"><?php __('Afficher les requêtes') ?></a>
                            <a href="#" class="debugSwitch" id="debugSwitchHide"><?php __('Cacher les requêtes') ?></a>
                        <?php endif; ?>
                    </div>
                <?php if(Configure::read('debug') == 2):?>
                    <script type="text/javascript">
                        $('debugSwitchShow').observe('click', function(e){
                            e.stop();
                            $('debugBox').removeClassName('debugHidden');
                            $('debugBox').addClassName('debugShow');
                            $$('.cake-sql-log').each(function(element){
                                element.show();
                            });
                        });
                        $('debugSwitchHide').observe('click', function(e){
                            e.stop();
                            $('debugBox').removeClassName('debugShow');
                            $('debugBox').addClassName('debugHidden');
                            $$('.cake-sql-log').each(function(element){
                                element.hide();
                            });
                        });
                        Event.observe(window, 'load', function(){
                            $$('.cake-sql-log').each(function(element){
                                element.hide();
                            });
                        });
                    </script>
                <?php endif; ?>
                <?php endif; ?>
                <div class="lhs_logo"></div>
                <div class="bo_footer_text">
                    Developped by <a href="http://www.lahautesociete.com" target="_new">La Haute Société</a>
                    <div style="position:relative;display:inline;">
                        <a onmouseover="$('copyright').style.display='block';" style="text-decoration: none;">©</a>
                        <?php echo $this->element('footer_copyright') ?>
                    </div> 2011
                </div>
            </div>
        </div>
    </div>
</div>
<div id="m_modalContainer"></div>
<div id="m_modalFade"><div id="m_modalFadeLoading"></div></div>
</body>
</html>
