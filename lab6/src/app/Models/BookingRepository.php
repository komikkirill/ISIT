<?php

namespace App\Models;

class BookingRepository
{
    private string $file;

    public function __construct()
    {
        $this->file = __DIR__ . '/../../storage/bookings.json';
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
        foreach ($this->all() as $booking) {
            if ($booking['id'] === $id) {
                return $booking;
            }
        }
        return null;
    }

    public function byStatus(?string $status): array
    {
        $all = $this->all();
        if (!$status) {
            return $all;
        }
        return array_filter($all, fn($b) => $b['status'] === $status);
    }

    public function add(array $data): void
    {
        $bookings = $this->all();
        $newId = empty($bookings) ? 1 : max(array_column($bookings, 'id')) + 1;
        $data['id'] = $newId;
        $bookings[] = $data;
        file_put_contents($this->file, json_encode($bookings, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}