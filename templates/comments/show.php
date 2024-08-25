<?php include __DIR__ . '/../header.php'; ?>

<style>
   body {
        background-color: #f4f4f4;
        color: #333;
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    h1,h4 {
        margin-left: 260px;
        font-size: 24px;
        color: #333;
        margin-bottom: 20px;
        font-weight: 700;
    }

    .p1 {
        margin-left: 260px;
        font-size: 16px;
        color: #333;
        margin-bottom: 20px;
        background-color: #fff; /* Подложка для текста */
        padding: 20px;
        border-radius: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    
    form {
        margin-left: 260px;
        max-width: 700px;
        margin-top: 20px;
        background-color: #fff;
        padding: 20px;
        border-radius: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        flex-direction: column;
    }
    label {
        font-size: 16px;
        color: #333;
        display: block;
        margin-bottom: 10px;
    }

    input[type="text"] {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        margin-bottom: 20px;
        border-radius: 10px;
        border: 1px solid #ddd;
        box-sizing: border-box;
        margin-right: 10px;
    }

    .a1 {
        color: #d9534f;
        text-decoration: none;
        margin-top: 10px;
        display: inline-block;
        border: 1px solid #d9534f;
        padding: 5px 10px;  
        border-radius: 5px;
        transition: background-color 0.3s, color 0.3s, box-shadow 0.3s;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        align-self: flex-end;
        font-size: 18px;
    }

    .a1:hover {
        background-color: #d9534f;
        color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
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

<h1><?= $article->getName() ?></h1>
<p class="p1"><?= $article->getText() ?></p>

<?php
$pattern = '~comments/(\d+)~';
preg_match($pattern, $_GET['route'], $matches);
?>

<?php foreach ($comments as $comment): ?>
    <?php if ($comment->getArticleId() == $matches[1]): ?>
        <h4>Комментарий:</h4>
        <p>
            <form action="/project/www/comments/edit/<?= $comment->getId(); ?>" method="post">
                <label><input type="text" name="text" value="<?= $comment->getText() ?>"></label>
                <a class="a1" href="/project/www/comments/delete/<?= $comment->getId(); ?>">Delete</a>
                <br><br>
                <input type="submit" value="Редактировать">
            </form>
        </p>
    <?php endif; ?>
<?php endforeach; ?>

<?php include __DIR__ . '/../footer.php'; ?>
