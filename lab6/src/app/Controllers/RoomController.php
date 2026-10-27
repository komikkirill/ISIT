<?php
namespace App\Controllers;

use App\Models\RoomRepository;
use App\Models\BookingRepository;

class RoomController
{
    public function index(): void {
        $roomRepo = new RoomRepository();
        $rooms = $roomRepo->all();
        view('rooms/index', ['rooms' => $rooms]);
    }

    public function show(string $id): void {
        $roomRepo = new RoomRepository();
        $bookingRepo = new BookingRepository();
        
        $room = $roomRepo->find((int)$id);
        if (!$room) {
            notFound();
        }
        
        $allBookings = $bookingRepo->all();
        $roomBookings = array_filter($allBookings, fn($b) => $b['room_id'] === (int)$id);
        
        view('rooms/show', ['room' => $room, 'bookings' => $roomBookings]);
    }
}