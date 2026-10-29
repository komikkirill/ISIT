<h1>Номер: <?= e($room['title']) ?></h1>
<p><?= e($room['description']) ?></p>

<h2 style="margin-top: 30px;">Бронирования этого номера</h2>
<?php if (empty($bookings)): ?>
    <p>Броней нет.</p>
<?php else: ?>
    <ul>
        <?php foreach ($bookings as $b): ?>
            <li style="margin-bottom: 10px;">
                <a href="/bookings/<?= e($b['id']) ?>">
                    <?= e($b['guest_name']) ?> (<?= e($b['check_in']) ?> - <?= e($b['check_out']) ?>)
                </a>
                — <strong><?= e($b['status']) ?></strong>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
<a href="/rooms" class="btn">Назад к фонду</a>