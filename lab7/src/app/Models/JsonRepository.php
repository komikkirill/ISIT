<?php
namespace App\Models;

abstract class JsonRepository
{
    protected string $file;

    public function all(): array {
        if (!file_exists($this->file)) return [];
        $data = file_get_contents($this->file);
        return json_decode($data, true) ?: [];
    }

    public function find(int $id): ?array {
        foreach ($this->all() as $item) {
            if ($item['id'] === $id) return $item;
        }
        return null;
    }

    public function add(array $data): array {
        $items = $this->all();
        $newId = empty($items) ? 1 : max(array_column($items, 'id')) + 1;
        $data['id'] = $newId;
        $items[] = $data;
        $this->save($items);
        return $data;
    }

    public function update(int $id, array $data): ?array {
        $items = $this->all();
        foreach ($items as $key => $item) {
            if ($item['id'] === $id) {
                $items[$key] = array_merge($item, $data);
                $items[$key]['id'] = $id; // ID менять нельзя
                $this->save($items);
                return $items[$key];
            }
        }
        return null;
    }

    public function delete(int $id): bool {
        $items = $this->all();
        foreach ($items as $key => $item) {
            if ($item['id'] === $id) {
                unset($items[$key]);
                $this->save(array_values($items));
                return true;
            }
        }
        return false;
    }

    protected function save(array $items): void {
        file_put_contents($this->file, json_encode($items, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}