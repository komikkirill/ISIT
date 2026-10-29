<?php
namespace App\Controllers;

use App\Models\BookingRepository;
use App\Models\RoomRepository;

class BookingController
{
    public function index(): void {
        $status = $_GET['status'] ?? null;
        $bookingRepo = new BookingRepository();
        $bookings = $bookingRepo->byStatus($status);
        
        view('bookings/index', ['bookings' => $bookings, 'currentStatus' => $status]);
    }

    public function show(string $id): void {
        $bookingRepo = new BookingRepository();
        $roomRepo = new RoomRepository();
        
        $booking = $bookingRepo->find((int)$id);
        if (!$booking) {
            notFound();
        }
        
        $room = $roomRepo->find($booking['room_id']);
        
        view('bookings/show', ['booking' => $booking, 'room' => $room]);
    }

    public function create(): void {
        $roomRepo = new RoomRepository();
        $rooms = $roomRepo->all();
        view('bookings/create', ['rooms' => $rooms]);
    }

    public function store(): void {
        $data = $_POST;
        $errors = [];

        if (empty($data['guest_name']) || mb_strlen($data['guest_name']) < 3) {
            $errors['guest_name'] = 'Имя гостя должно быть не короче 3 символов';
        }
        if (empty($data['room_id'])) {
            $errors['room_id'] = 'Выберите номер';
        }
        if (empty($data['check_in']) || empty($data['check_out'])) {
            $errors['dates'] = 'Укажите даты заезда и выезда';
        } elseif ($data['check_in'] >= $data['check_out']) {
            $errors['dates'] = 'Дата выезда должна быть позже даты заезда';
        }

        if (!empty($errors)) {
            http_response_code(422);
            $roomRepo = new RoomRepository();
            view('bookings/create', [
                'rooms' => $roomRepo->all(),
                'errors' => $errors,
                'old' => $data
            ]);
            return;
        }

        $bookingRepo = new BookingRepository();
        $bookingRepo->add([
            'room_id' => (int)$data['room_id'],
            'guest_name' => $data['guest_name'],
            'check_in' => $data['check_in'],
            'check_out' => $data['check_out'],
            'status' => 'new'
        ]);

        redirect('/bookings');
    }
}