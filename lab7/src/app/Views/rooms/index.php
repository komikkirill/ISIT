<h1>Номерной фонд</h1>
<ul class="room-list" style="list-style: none; padding: 0;">
    <?php foreach ($rooms as $room): ?>
        <li style="background: #fff; padding: 15px; margin-bottom: 10px; border-radius: 5px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <a href="/rooms/<?= e($room['id']) ?>" style="font-size: 18px; color: #3498db; text-decoration: none;"><strong><?= e($room['title']) ?></strong></a>
            <p style="margin: 5px 0 0 0; color: #666;"><?= e($room['description']) ?></p>
        </li>
    <?php endforeach; ?>
</ul>