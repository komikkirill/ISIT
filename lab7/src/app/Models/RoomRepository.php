<?php

namespace App\Models;

class RoomRepository
{
    private string $file;

    public function __construct()
    {
        $this->file = __DIR__ . '/../../storage/rooms.json';
    }

    public function all(): array
    {
        if (!file_exists($this->file)) {
            return [];
        }
        $data = file_get_contents($this->file);
        return json_decode($data, true) ?: [];
    }

    public function find(int $id): ?array
    {
        foreach ($this->all() as $room) {
            if ($room['id'] === $id) {
                return $room;
            }
        }
        return null;
    }

    public function getBookingsCount(int $roomId): int
    {
        $bookingRepo = new BookingRepository();
        $bookings = $bookingRepo->all();
        $count = 0;
        foreach ($bookings as $b) {
            if ($b['room_id'] === $roomId && $b['status'] !== 'done') {
                $count++;
            }
        }
        return $count;
    }
}