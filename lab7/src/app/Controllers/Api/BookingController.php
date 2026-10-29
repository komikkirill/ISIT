<?php
namespace App\Controllers\Api;

use App\Models\BookingRepository;
use App\Models\RoomRepository;

class BookingController
{
    public function index(): void {
        $status = $_GET['status'] ?? null;
        $repo = new BookingRepository();
        json_response($repo->byStatus($status));
    }

    public function show(string $id): void {
        $repo = new BookingRepository();
        $booking = $repo->find((int)$id);
        if (!$booking) json_error('Бронирование не найдено', 404);
        json_response($booking);
    }

    public function store(): void {
        $data = json_input();
        $errors = $this->validate($data);
        if (!empty($errors)) json_error('Ошибка проверки данных', 422, $errors);

        $repo = new BookingRepository();
        $newBooking = $repo->add([
            'room_id' => (int)$data['room_id'],
            'guest_name' => $data['guest_name'],
            'check_in' => $data['check_in'],
            'check_out' => $data['check_out'],
            'status' => $data['status'] ?? 'new'
        ]);
        
        header('Location: /api/bookings/' . $newBooking['id']);
        json_response($newBooking, 201);
    }

    public function update(string $id): void {
        $data = json_input();
        $repo = new BookingRepository();
        $booking = $repo->find((int)$id);
        if (!$booking) json_error('Бронирование не найдено', 404);

        $errors = $this->validate(array_merge($booking, $data));
        if (!empty($errors)) json_error('Ошибка проверки данных', 422, $errors);

        $updated = $repo->update((int)$id, $data);
        json_response($updated, 200);
    }

    public function destroy(string $id): void {
        $repo = new BookingRepository();
        if (!$repo->find((int)$id)) json_error('Бронирование не найдено', 404);
        $repo->delete((int)$id);
        no_content();
    }

    private function validate(array $data): array {
        $errors = [];
        if (empty($data['guest_name']) || mb_strlen($data['guest_name']) < 3) {
            $errors['guest_name'] = 'Имя гостя должно быть не короче 3 символов';
        }
        if (empty($data['room_id'])) {
            $errors['room_id'] = 'Укажите номер комнаты';
        } else {
            $roomRepo = new RoomRepository();
            if (!$roomRepo->find((int)$data['room_id'])) {
                $errors['room_id'] = 'Номера с таким ID не существует';
            }
        }
        if (empty($data['check_in']) || empty($data['check_out'])) {
            $errors['dates'] = 'Укажите даты заезда и выезда';
        } elseif ($data['check_in'] >= $data['check_out']) {
            $errors['dates'] = 'Дата выезда должна быть позже даты заезда';
        }
        return $errors;
    }
}