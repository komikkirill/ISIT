<h1>Бронирование #<?= e($booking['id']) ?></h1>
<div class="details">
    <p><strong>Гость:</strong> <?= e($booking['guest_name']) ?></p>
    <p><strong>Номер:</strong> <?= $room ? e($room['title']) : 'Не найден' ?></p>
    <p><strong>Даты:</strong> с <?= e($booking['check_in']) ?> по <?= e($booking['check_out']) ?></p>
    <p><strong>Статус:</strong> <?= e($booking['status']) ?></p>
</div>
<a href="/bookings" class="btn">Назад к списку</a>