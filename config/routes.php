<?php

$routes = new Router;

// Routes Abonnes
$routes->get('abonnes',             'AbonnesController@index'); // Liste des abonnés
$routes->get('abonnes/(\d+)',       'AbonnesController@show');  // Affichage et édition d'un abonné
$routes->get('abonnes/add',         'AbonnesController@add');   // Formulaire d'ajout d'un abonné
$routes->post('abonnes/save',       'AbonnesController@save');  // Servira autant à l'INSERT qu'à l'UPDATE
$routes->get('abonnes/delete/(\d+)','AbonnesController@delete');// Suppression d'un abonné

// Routes Ouvrages
$routes->get('ouvrages',                 'OuvragesController@index');
$routes->get('ouvrages/(\d+)',           'OuvragesController@show');
$routes->get('ouvrages/add',             'OuvragesController@add');
$routes->post('ouvrages/save',           'OuvragesController@save');
$routes->get('ouvrages/delete/(\d+)',    'OuvragesController@delete');

//Routes AbonnesOuvrages: prêts d'ouvrages
$routes->get('prets',                   'AbonnesOuvragesController@index');
$routes->get('prets/(\d+)',             'AbonnesOuvragesController@show');
$routes->get('prets/add',               'AbonnesOuvragesController@add');
$routes->post('prets/save',             'AbonnesOuvragesController@save');
$routes->get('prets/delete/(\d+)',      'AbonnesOuvragesController@delete');

$routes->get('/',                        'PagesController@home');

// Exercices de requêtes
/* $routes->get('/listeNomsEmprunteurs',    'EmprunteursDisquesController@listeNomsEmprunteurs');
$routes->get('/nombreDisquesParEmprunteur',   'EmprunteursDisquesController@nombreDisquesParEmprunteur'); */

$routes->run();
