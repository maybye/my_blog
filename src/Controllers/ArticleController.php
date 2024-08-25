<?php

namespace Controllers;

use View\View;
use Models\Articles\Article;
use Models\Users\User;
use Models\Comments\Comment;
use Models\Categories\Category;
use Models\ActiveRecordEntity;

class ArticleController
{

    private $view;

    public function __construct()
    {
        $this->view = new View(__DIR__.'/../../templates');
    }

    public function create()
    {
        $users = User::findAll();
        $categories = Category::findAll();
        $this->view->renderHtml('articles/create.php', ['users' => $users, 'categories' => $categories]);
    }

    public function show(int $id)
    {
        $article = Article::getById($id);

        if (empty($article)) {
            $this->view->renderHtml('errors/404.php', [], 404);
            return;
        }

        // Используйте метод getCategoryName для получения имени категории
        $categoryName = $article->getCategoryName();

        if (!$categoryName) {
            $categoryName = 'Категория не указана';
        }

        $comments = Comment::findAll();

        $filteredComments = array_filter($comments, function ($comment) use ($id) {
            return $comment->getArticleId() == $id;
        });

        $this->view->renderHtml('articles/show.php', ['article' => $article, 'categoryName' => $categoryName, 'comments' => $filteredComments]);
    }

    public function edit(int $id)
    {
        $article = Article::getById($id);
        $categories = Category::findAll();
        $this->view->renderHtml('articles/edit.php', ['article' => $article, 'categories' => $categories]);
    }

    public function update($id)
    {
        $article = Article::getById($id);
        $article->setName($_POST['name']);
        $article->setText($_POST['text']);

        if (!empty($_POST['category'])) {
            $categoryName = $_POST['category'];
            $category = Category::findOneBy(['name' => $categoryName]);

            if (!$category) {
                $category = new Category;
                $category->setName($categoryName);
                $category->save();
            }

            $article->setCategoryId($category->getCategoryId());
        }

        $article->save();
    }

    public function add()
{
    $article = new Article;
    $user = User::getById((int) $_POST['author']);
    $article->setName($_POST['name']);
    $article->setText($_POST['text']);
    $article->setAuthorId($user);

    if (!empty($_POST['category'])) {
        $categoryName = $_POST['category'];
        $existingCategory = Category::findOneBy(['name' => $categoryName]);

        if ($existingCategory) {
            $article->setCategoryId($existingCategory);
        } else {
            $newCategory = new Category;
            $newCategory->setName($categoryName);
            $newCategory->save();

            $article->setCategoryId($newCategory);
        }
    }

    $article->save();
    header('Location: http://localhost/project/project/www/');
}


    public function delete(int $id)
    {
        $article = Article::getById($id);
        $article->destroy();
        header('Location: http://localhost/project/project/www/');
    }

    

  
    public function like(int $articleId)
    {
        session_start();
        if (isset($_SESSION['user_id'])) {
            $user = User::getById($_SESSION['user_id']);
        } else {
            header('Location: http://localhost/project/project/www/login');
            exit; // Добавьте exit после редиректа, чтобы прекратить выполнение скрипта
        }
    
        $article = Article::getById($articleId);
        if ($article === null) {
            header('Location: http://localhost/project/project/www/404');
            exit; // Добавьте exit после редиректа, чтобы прекратить выполнение скрипта
        }
        if ($user && $article->isLikedByUser($user)) {
            $article->unlike($user); // Вызовите метод unlike, если пользователь уже поставил лайк
        } else {
            $article->like($user); // Поставить лайк, если его не было
        }
    
        // Перенаправление обратно на страницу статьи
        header('Location: ' . $_SERVER['HTTP_REFERER']); // Лучше вернуть пользователя на страницу, откуда он пришел
        exit;
    }
    

}

