<div class="header-actions">
    <h1>Список бронирований</h1>
    <a href="/bookings/create" class="btn">Создать бронь</a>
</div>

<div class="filters" style="margin-top: 15px;">
    <form method="GET" action="/bookings">
        <label>Фильтр по статусу:</label>
        <select name="status" onchange="this.form.submit()">
            <option value="">Все</option>
            <option value="new" <?= $currentStatus === 'new' ? 'selected' : '' ?>>Новые</option>
            <option value="in_progress" <?= $currentStatus === 'in_progress' ? 'selected' : '' ?>>В процессе</option>
            <option value="done" <?= $currentStatus === 'done' ? 'selected' : '' ?>>Завершенные</option>
        </select>
    </form>
</div>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Гость</th>
            <th>Даты</th>
            <th>Статус</th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($bookings)): ?>
            <tr><td colspan="5">Бронирования не найдены</td></tr>
        <?php else: ?>
            <?php foreach ($bookings as $b): ?>
                <tr>
                    <td><?= e($b['id']) ?></td>
                    <td><?= e($b['guest_name']) ?></td>
                    <td><?= e($b['check_in']) ?> — <?= e($b['check_out']) ?></td>
                    <td>
                        <?php 
                        $statuses = ['new' => 'Новая', 'in_progress' => 'В процессе', 'done' => 'Завершена'];
                        echo e($statuses[$b['status']] ?? $b['status']); 
                        ?>
                    </td>
                    <td><a href="/bookings/<?= e($b['id']) ?>">Просмотр</a></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>