<?php

/** @var Router $router */
$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('home', ['controller' => 'Home', 'action' => 'index']);
// Auth rute
$router->add('login', ['controller' => 'Auth', 'action' => 'login']);
$router->add('logout', ['controller' => 'Auth', 'action' => 'logout']);
$router->add('register', ['controller' => 'Auth', 'action' => 'register']);
// Exercise rute (katalog vezbi)
$router->add('exercises', ['controller' => 'Exercises', 'action' => 'index']);
$router->add('exercises/view/{id}', ['controller' => 'Exercises', 'action' => 'viewExercise']);
$router->add('exercises/create', ['controller' => 'Exercises', 'action' => 'create']);
$router->add('exercises/edit/{id}', ['controller' => 'Exercises', 'action' => 'edit']);
$router->add('exercises/delete/{id}', ['controller' => 'Exercises', 'action' => 'delete']);
// Workout rute (treninzi)
$router->add('workouts', ['controller' => 'Workouts', 'action' => 'index']);
$router->add('workouts/view/{id}', ['controller' => 'Workouts', 'action' => 'viewWorkout']);
$router->add('workouts/create', ['controller' => 'Workouts', 'action' => 'create']);
$router->add('workouts/edit/{id}', ['controller' => 'Workouts', 'action' => 'edit']);
$router->add('workouts/delete/{id}', ['controller' => 'Workouts', 'action' => 'delete']);
// Measurement rute (merenja tela)
$router->add('measurements', ['controller' => 'Measurements', 'action' => 'index']);
$router->add('measurements/create', ['controller' => 'Measurements', 'action' => 'create']);
$router->add('measurements/delete/{id}', ['controller' => 'Measurements', 'action' => 'delete']);
// Dashboard ruta
$router->add('dashboard', ['controller' => 'Dashboard', 'action' => 'index']);
// Admin rute
$router->add('admin', ['controller' => 'Admin', 'action' => 'index']);
$router->add('admin/users', ['controller' => 'Admin', 'action' => 'users']);
$router->add('admin/stats', ['controller' => 'Admin', 'action' => 'stats']);
// Export/Import rute
$router->add('export/workouts', ['controller' => 'Export', 'action' => 'workouts']);
$router->add('export/measurements', ['controller' => 'Export', 'action' => 'measurements']);
$router->add('import/workouts', ['controller' => 'Import', 'action' => 'workouts']);
$router->add('import/measurements', ['controller' => 'Import', 'action' => 'measurements']);
