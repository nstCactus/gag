<header class="Header" role="banner">
    <h1 class="Header_siteTitle" role="heading">{'site.title'|dico:'GAG'}</h1>

    <nav class="Header_menu HeaderMenu" role="navigation">
        {'header'|cms_node:[
            'menu_template' => [
                ['<ul class="HeaderMenu_list">', '</ul>']
            ],
            'line_template' => '<li class="HeaderMenu_item"><a href="%LINK%" class="HeaderMenu_link HeaderMenu_link-current%CURRENT_PAGE% HeaderMenu_link-containCurrent%CONTAIN_CURRENT_PAGE%">%NAME%</a></li>'
        ]}
    </nav>

    {* TODO: Ajouter un bouton panier pour les utilisateurs connectés *}

    {* TODO: Remplacer ca par un appel à un composant gérant le cas où l'utilisateur est connecté *}
    <a class="Header_rightLink" href="{[
        'controller' => 'user',
        'action'     => 'login'
    ]|route}">{'action.login'|dico:'Connexion'}</a>
</header>
