<?php

$routes = [
    '/' => 'HomeController@index',

    '/login' => 'UserController@login',
    '/verify' => 'UserController@verify',
    '/logout' => 'UserController@logout',
    '/register' => 'UserController@register',

    '/contact_info/save' => 'ContactInfoController@save',
    '/contact_info/delete/{id}' => 'ContactInfoController@delete',
    '/contact_info/get_all' => 'ContactInfoController@getContactInfo',

    '/user/create' => 'UserController@create',

    '/schedule' => 'ScheduleController@index',
    '/schedule/create' => 'ScheduleController@create',
    '/schedule/get_all' => 'ScheduleController@getAllSchedules',
    '/schedule/get_by_user' => 'ScheduleController@getSchedulesByUser',
    '/schedule/update_status' => 'ScheduleController@updateStatus',

    '/admin' => 'AdminController@index',

    '/profile' => 'ProfileController@index',

    '/service/save' => 'ServiceController@save',
    '/service/delete/{id}' => 'ServiceController@delete',
    '/service/get_all' => 'ServiceController@getAllServices',


    '/barber/save' => 'BarberController@save',
    '/barber/delete/{id}' => 'BarberController@delete',
    '/barber/get_all' => 'BarberController@getAllBarbers',

];
