<?php

require_once __DIR__ . '/../app/Models/JsonRepository.php';
require_once __DIR__ . '/../app/Controllers/Api/BookingController.php';
require_once __DIR__ . '/../app/Controllers/Api/RoomController.php';
require_once __DIR__ . '/../app/Controllers/Api/GuestController.php';

// --- МАРШРУТЫ САЙТА (ЛР6) ---
$router->get('/', [\App\Controllers\HomeController::class, 'index']);

$router->get('/bookings', [\App\Controllers\BookingController::class, 'index']);
$router->get('/bookings/create', [\App\Controllers\BookingController::class, 'create']);
$router->post('/bookings', [\App\Controllers\BookingController::class, 'store']);
$router->get('/bookings/{id}', [\App\Controllers\BookingController::class, 'show']);

$router->get('/rooms', [\App\Controllers\RoomController::class, 'index']);
$router->get('/rooms/{id}', [\App\Controllers\RoomController::class, 'show']);


// --- МАРШРУТЫ API (ЛР7) ---

// Бронирования
$router->get('/api/bookings', [\App\Controllers\Api\BookingController::class, 'index']);
$router->post('/api/bookings', [\App\Controllers\Api\BookingController::class, 'store']);
$router->get('/api/bookings/{id}', [\App\Controllers\Api\BookingController::class, 'show']);
$router->put('/api/bookings/{id}', [\App\Controllers\Api\BookingController::class, 'update']);
$router->patch('/api/bookings/{id}', [\App\Controllers\Api\BookingController::class, 'update']);
$router->delete('/api/bookings/{id}', [\App\Controllers\Api\BookingController::class, 'destroy']);

// Номера
$router->get('/api/rooms', [\App\Controllers\Api\RoomController::class, 'index']);
$router->post('/api/rooms', [\App\Controllers\Api\RoomController::class, 'store']);
$router->get('/api/rooms/{id}', [\App\Controllers\Api\RoomController::class, 'show']);
$router->put('/api/rooms/{id}', [\App\Controllers\Api\RoomController::class, 'update']);
$router->patch('/api/rooms/{id}', [\App\Controllers\Api\RoomController::class, 'update']);
$router->delete('/api/rooms/{id}', [\App\Controllers\Api\RoomController::class, 'destroy']);

// Гости
$router->get('/api/guests', [\App\Controllers\Api\GuestController::class, 'index']);
$router->post('/api/guests', [\App\Controllers\Api\GuestController::class, 'store']);
$router->get('/api/guests/{id}', [\App\Controllers\Api\GuestController::class, 'show']);
$router->put('/api/guests/{id}', [\App\Controllers\Api\GuestController::class, 'update']);
$router->patch('/api/guests/{id}', [\App\Controllers\Api\GuestController::class, 'update']);
$router->delete('/api/guests/{id}', [\App\Controllers\Api\GuestController::class, 'destroy']);