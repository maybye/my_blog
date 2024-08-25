<?php include __DIR__ . '/../header.php'; ?>

<style>
    h1, h2, h5 {
        margin-left: 260px;
        font-size: 24px;
        color: #333;
        margin-bottom: 20px;
        font-weight: 700;
    }

    h4 {
        font-size: 24px;
        color: #333;
        margin-bottom: 20px;
        font-weight: 700;
    }

    .p1 {
        margin-left: 260px;
        font-weight: 700;
        font-size: 18px;
        color: #333;
        margin-bottom: 20px;
        background-color: #fff;
        padding: 20px;
        margin-bottom: 10px;
        border-radius: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .card {
        margin-left: 260px;
        background-color: #fff;
        padding: 20px;
        margin-bottom: 10px;
        border-radius: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .card-title {
        font-size: 20px;
        color: #333;
        margin-bottom: 10px;
    }

    .card-subtitle {
        font-size: 16px;
        color: #333;
    }

    .a1 {
        margin-left: 692px;
        padding: 10px 20px;
        font-size: 18px;
        font-weight: 700;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        transition: background-color 0.3s, color 0.3s, box-shadow 0.3s;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        text-decoration: none;
        display: inline-block;
    }

    .a1:hover {
        color: #fff;
        background-color: #0056b3;
    }

    form {
        max-width: 700px;
        background-color: #fff;
        padding: 20px;
        border-radius: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        flex-direction: column;
        margin-left:260px;
    }

    label {
        font-size: 18px;
        color: #333;
        display: block;
    }

    input[type="text"] {
        width: 100%;
        padding: 10px;
        font-size: 18px;
        border-radius: 10px;
        border: 1px solid #ddd;
    }

    input[type="submit"] {
        background-color: #28a745;
        color: #fff;
        padding: 10px 20px;
        font-size: 18px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        transition: background-color 0.3s, color 0.3s, box-shadow 0.3s;
    }

    input[type="submit"]:hover {
        background-color: #218838;
    }
</style>

<?php
    $pattern = '~article/show/(\d+)~';
    preg_match($pattern, $_GET['route'], $matches);
?>

<h1><?= $article->getName() ?></h1>

<!-- Отображение категории -->
<?php $category = $article->getCategory(); ?>
<?php if ($category): ?>
    <p class="p1"><strong>Категория:</strong> <?= $category->getName() ?></p>
<?php else: ?>
    <p class="p1"><strong>Категория:</strong> Категория не указана</p>
<?php endif; ?>

<p class="p1"><?= $article->getText() ?></p>

<h5 class="title">Комментарии:</h5>

<?php foreach ($comments as $comment): ?>
    <?php if ($comment->getArticleId() == $matches[1]): ?>
        <div class="card">
            <h4 class="card-title">Комментарий:</h4>
            <p class="card-subtitle"><?= $comment->getText() ?></p>
        </div>
    <?php endif; ?>
<?php endforeach; ?>

<a class="a1" href="/project/project/www/comments/<?= $article->getId() ?>">Редактировать комментарии</a>

<div>
    <h2>Добавить комментарий</h2>
    <form action="/project/project/www/comments/add/<?= $article->getId() ?>" method="post">
        <label>Текст <input type="text" name="text"></label>

        <br><br>

        <input type="submit" value="Добавить">
    </form>
</div>

<?php include __DIR__ . '/../footer.php'; ?>