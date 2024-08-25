<?php
include __DIR__.'/../header.php';


$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
$filteredArticles = array_filter($articles, function ($article) use ($searchTerm) {
    return strpos(strtolower($article->getName()), strtolower($searchTerm)) !== false;
});

echo '<form method="get" action="">
    <input type="text" id="search" name="search" value="' . htmlspecialchars($searchTerm) . '">
    <input type="submit" value="Поиск">
</form>';

foreach ($filteredArticles as $article) {
    echo '<div class="article">';
    echo '<a href="article/show/' . $article->getId() . '">' . $article->getName() . '</a>';
    $category = $article->getCategory();
    if ($category) {
        echo '<p class="category">Категория: ' . $category->getName() . '</p>';
    } else {
        echo '<p class="category">Категория не указана</p>';
    }

    echo '<p class="author">' . $article->getAuthorId()->getNickName() . '</p>';
    echo '<p>' . $article->getText() . '</p>';
    
    echo '<p class="likes">Лайки: ' . $article->getLikesCount() . '</p>';

    // Кнопка для постановки лайка с отдельным стилем
    echo '<form class="like-form specific-style" method="post" action="/project/project/www/article/like/' . $article->getId() . '">
    <input type="submit" value="Лайк" class="like-button">
</form>'; 

    echo '<a class="delete-link" href="article/delete/' . $article->getId() . '">Delete</a>';
    echo '</div>';
}

include __DIR__ . '/../footer.php';
?>