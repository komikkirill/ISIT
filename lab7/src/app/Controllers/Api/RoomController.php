<?php
namespace App\Controllers\Api;

use App\Models\RoomRepository;
use App\Models\BookingRepository;

class RoomController
{
    public function index(): void {
        $repo = new RoomRepository();
        json_response($repo->all());
    }

    public function show(string $id): void {
        $repo = new RoomRepository();
        $room = $repo->find((int)$id);
        if (!$room) json_error('Номер не найден', 404);
        json_response($room);
    }

    public function store(): void {
        $data = json_input();
        $errors = [];
        if (empty($data['title']) || mb_strlen($data['title']) < 3) $errors['title'] = 'Название не короче 3 символов';
        if (empty($data['description'])) $errors['description'] = 'Добавьте описание';
        
        if (!empty($errors)) json_error('Ошибка проверки данных', 422, $errors);

        $repo = new RoomRepository();
        $newRoom = $repo->add(['title' => $data['title'], 'description' => $data['description']]);
        header('Location: /api/rooms/' . $newRoom['id']);
        json_response($newRoom, 201);
    }

    public function update(string $id): void {
        $data = json_input();
        $repo = new RoomRepository();
        if (!$repo->find((int)$id)) json_error('Номер не найден', 404);
        
        $updated = $repo->update((int)$id, $data);
        json_response($updated, 200);
    }

    public function destroy(string $id): void {
        $repo = new RoomRepository();
        if (!$repo->find((int)$id)) json_error('Номер не найден', 404);
        
        // Бизнес-правило: нельзя удалить номер, если на него есть активные брони (409)
        if ($repo->getBookingsCount((int)$id) > 0) {
            json_error('Нельзя удалить номер: есть активные бронирования', 409);
        }
        
        $repo->delete((int)$id);
        no_content();
    }
}