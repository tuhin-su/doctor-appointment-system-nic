<?php

return [
    'login'     => ['component' => 'login',         'auth' => false],
    'register'  => ['component' => 'registration',  'auth' => false],
    'dashboard' => ['component' => 'dashboard',     'auth' => true,  'roles' => ['Admin', 'Doctor', 'Patient']],
    'profile'   => ['component' => 'profile',       'auth' => true,  'roles' => ['Admin', 'Doctor', 'Patient']],
    'appointment-booking'     => ['component' => 'appointment-booking',   'auth' => true,  'roles' => ['Patient']],
    'logout'     => ['component' => 'logout',   'auth' => true,  'roles' =>  ['Admin', 'Doctor', 'Patient']],
    'user-master'     => ['component' => 'user-master',   'auth' => true,  'roles' =>  ['Admin']],
    'doctor-appointment'     => ['component' => 'doctor-appointment',   'auth' => true,  'roles' =>  ['Admin', 'Doctor']],
    'my-appointments'     => ['component' => 'my-appointments',   'auth' => true,  'roles' =>  ['Patient']],
    'doctor-appointments'     => ['component' => 'doctor-appointments',   'auth' => true,  'roles' =>  ['Doctor']],
];
