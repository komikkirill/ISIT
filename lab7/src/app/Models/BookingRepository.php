<?php
namespace App\Models;

class BookingRepository extends JsonRepository
{
    public function __construct() {
        $this->file = __DIR__ . '/../../storage/bookings.json';
    }

    public function byStatus(?string $status): array {
        $all = $this->all();
        if (!$status) return $all;
        return array_filter($all, fn($b) => $b['status'] === $status);
    }
}