<?php

use App\Controllers\HomeController;
use App\Controllers\BookingController;
use App\Controllers\RoomController;

// Главная страница
$router->get('/', [HomeController::class, 'index']);

// Маршруты для бронирований (ВАЖЕН ПОРЯДОК!)
$router->get('/bookings', [BookingController::class, 'index']);
$router->get('/bookings/create', [BookingController::class, 'create']); // Должен быть выше /{id}
$router->post('/bookings', [BookingController::class, 'store']);
$router->get('/bookings/{id}', [BookingController::class, 'show']);

// Маршруты для номерного фонда
$router->get('/rooms', [RoomController::class, 'index']);
$router->get('/rooms/{id}', [RoomController::class, 'show']);