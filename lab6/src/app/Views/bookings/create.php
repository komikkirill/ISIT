<h1>Новое бронирование</h1>

<?php if (!empty($errors)): ?>
    <div class="error-box">
        <?php foreach ($errors as $error): ?>
            <p><?= e($error) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form method="POST" action="/bookings" class="form">
    <div class="form-group">
        <label>ФИО Гостя</label>
        <input type="text" name="guest_name" value="<?= e($old['guest_name'] ?? '') ?>">
    </div>
    
    <div class="form-group">
        <label>Номер</label>
        <select name="room_id">
            <option value="">-- Выберите --</option>
            <?php foreach ($rooms as $room): ?>
                <option value="<?= e($room['id']) ?>" <?= ($old['room_id'] ?? '') == $room['id'] ? 'selected' : '' ?>>
                    <?= e($room['title']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    
    <div class="form-group">
        <label>Дата заезда</label>
        <input type="date" name="check_in" value="<?= e($old['check_in'] ?? '') ?>">
    </div>
    
    <div class="form-group">
        <label>Дата выезда</label>
        <input type="date" name="check_out" value="<?= e($old['check_out'] ?? '') ?>">
    </div>
    
    <button type="submit" class="btn">Сохранить</button>
</form>