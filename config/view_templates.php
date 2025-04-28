<?php
/********************************************
Fichier pour définir les templates de vues standards 
*********************************************

    ---exemple de vue par defaut de vue de connexion---

    'login' => [
        'page_name' => 'page_de_connection',
        'inputs' => ['email', 'password'],
        'redirection' => 'dashboard'
    ],

************************************/

return [
    'login' => [
        'page_name' => 'page_de_connection',
        'inputs' => ['email', 'password'],
        'redirection' => 'dashboard'
    ],
    'signin' => [
        'page_name' => 'inscription',
        'inputs' => ['nom', 'prenom', 'email', 'password'],
        'redirection' => 'dashboard'
    ],
];
