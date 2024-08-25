<?php include __DIR__.'/../header.php'; ?>

<style>
    body {
        background-color: #f4f4f4;
        color: #333;
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    h1 {
        margin-left: 260px;
        font-size: 24px;
        color: #333;
        margin-bottom: 20px;
        font-weight: 700;
    }

    .session-status {
        margin-left: 260px;
        font-size: 16px;
        color: #4CAF50;
        margin-bottom: 10px;
    }

    .data-container {
        margin-left: 260px;
        background-color: #fff;
        padding: 15px;
        border-radius: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    .data-container p {
        font-size: 16px;
        color: #333;
        margin-bottom: 10px;
    }

    .error {
        margin-left: 260px;
        font-size: 16px;
        color: #ff0000;
        margin-bottom: 10px;
    }
</style>

<h1>Обо мне</h1>

<?php if (session_status() === PHP_SESSION_ACTIVE): ?>
    <p class="session-status">Session is active.</p>
<?php else: ?>
    <p class="session-status">Session is not active.</p>
<?php endif; ?>

<?php if (isset($_SESSION['nickname'], $_SESSION['email'])): ?>
    <div class="data-container">
        <p>Nickname: <?php echo htmlspecialchars($_SESSION['nickname']); ?></p>
        <p>Email: <?php echo htmlspecialchars($_SESSION['email']); ?></p>
    </div>
<?php else: ?>
    <p class="error">Error: User data not available.</p>
<?php endif; ?>

<?php include __DIR__ . '/../footer.php'; ?>
