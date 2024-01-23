<?php

namespace Api\Php\Router;


Router::get('/user','UserController@find');
Router::post('/user', 'UserController@create');
Router::get('/post', 'PostController@find');
Router::post('/user', 'PostController@create');