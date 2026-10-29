<h1>500 — Внутренняя ошибка сервера</h1>
<p>Что-то пошло не так. Попробуйте повторить действие позже.</p>

<?php if (config('debug') && isset($error)): ?>
    <div style="background: #f8d7da; color: #721c24; padding: 15px; margin-top: 20px;">
        <strong>Для разработчика:</strong>
        <p><?= e($error->getMessage()) ?></p>
        <pre><?= e($error->getTraceAsString()) ?></pre>
    </div>
<?php endif; ?>