<?php include __DIR__ . '/../header.php'; ?>

<style>
    h3 {
        margin-left: 260px;
        font-size: 24px;
        font-weight: 700;
        color: #333;
        margin-bottom: 20px;
    }

    form {
        max-width: 700px;
        margin-left: 260px;
        background-color: #fff;
        padding: 20px;
        border-radius: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column; /* Располагаем элементы в столбец */
    }

    .mb-3 {
        margin-bottom: 10px;
    }

    .form-label {
        font-size: 16px;
        color: #333;
        border-radius: 10px;
    }

    .form-control {
        padding: 10px;
        font-size: 20px;
        border-radius: 10px;
    }

    .btn-success {
        padding: 10px 20px;
        font-size: 20px;
        background-color: #5cb85c;
        color: #fff;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        transition: background-color 0.3s, color 0.3s, box-shadow 0.3s;
    }

    .btn-success:hover {
        background-color: #4cae4c;
    }
</style>

<h3>Новая статья</h3>

<form action="add" method="post">
    <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Заголовок статьи</label>
        <input name="name" type="text" class="form-control" id="exampleFormControlInput1" placeholder="title">
    </div>
    <div class="mb-3">
        <label for="exampleFormControlTextarea1" class="form-label">Текст статьи</label>
        <textarea type="text" name="text" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
    </div>
    <div class="mb-3">
        <label for="exampleFormControlInput2" class="form-label">Категория</label>
        <input name="category" type="text" class="form-control" id="exampleFormControlInput2" placeholder="category">
    </div>
    <div class="mb-3">
        <label for="exampleFormControlSelect2" class="form-label">Выберите автора</label>
        <select name="author" class="form-control" id="exampleFormControlSelect2">
            <option selected>Выберите автора</option>
            <?php foreach ($users as $user): ?>
                <option value="<?= $user->getId(); ?>"><?= $user->getNickName(); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <button class="btn btn-success" type="submit">Сохранить</button>
</form>

<?php include __DIR__ . '/../footer.php'; ?>
