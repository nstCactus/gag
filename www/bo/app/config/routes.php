<?php

Router::connect('/', array('controller' => 'pages', 'action' => 'index'));

Router::connect('/login', array('controller' => 'users', 'action' => 'login'));
Router::connect('/logout', array('controller' => 'users', 'action' => 'logout'));