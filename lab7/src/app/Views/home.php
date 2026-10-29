<h1>Главная</h1>

<div class="cards" style="display: flex; gap: 15px; flex-wrap: wrap; margin-top: 20px;">
    <div class="card" style="border: 1px solid #ccc; padding: 20px; border-radius: 8px; width: 200px; text-align: center;">
        <h3>Всего броней</h3>
        <p style="font-size: 24px; font-weight: bold; color: #2c3e50;"><?= e($stats['total']) ?></p>
    </div>

    <div class="card" style="border: 1px solid #ccc; padding: 20px; border-radius: 8px; width: 200px; text-align: center;">
        <h3>Новые</h3>
        <p style="font-size: 24px; font-weight: bold; color: #3498db;"><?= e($stats['new']) ?></p>
    </div>

    <div class="card" style="border: 1px solid #ccc; padding: 20px; border-radius: 8px; width: 200px; text-align: center;">
        <h3>В процессе</h3>
        <p style="font-size: 24px; font-weight: bold; color: #f39c12;"><?= e($stats['in_progress']) ?></p>
    </div>

    <div class="card" style="border: 1px solid #ccc; padding: 20px; border-radius: 8px; width: 200px; text-align: center;">
        <h3>Завершено</h3>
        <p style="font-size: 24px; font-weight: bold; color: #27ae60;"><?= e($stats['done']) ?></p>
    </div>

    <div class="card" style="border: 1px solid #ccc; padding: 20px; border-radius: 8px; width: 200px; text-align: center;">
        <h3>Номеров в фонде</h3>
        <p style="font-size: 24px; font-weight: bold; color: #8e44ad;"><?= e($stats['rooms_count']) ?></p>
    </div>
</div>