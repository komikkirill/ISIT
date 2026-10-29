<?php

namespace App\Controllers;

use App\Models\BookingRepository;
use App\Models\RoomRepository;

class HomeController
{
    public function index(): void
    {
        $bookingRepo = new BookingRepository();
        $roomRepo = new RoomRepository();
        
        $bookings = $bookingRepo->all();
        
        $stats = [
            'total' => count($bookings),
            'new' => count(array_filter($bookings, fn($b) => $b['status'] === 'new')),
            'in_progress' => count(array_filter($bookings, fn($b) => $b['status'] === 'in_progress')),
            'done' => count(array_filter($bookings, fn($b) => $b['status'] === 'done')),
            'rooms_count' => count($roomRepo->all())
        ];

        view('home', ['stats' => $stats]);
    }
}