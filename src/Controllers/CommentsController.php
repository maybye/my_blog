<?php

namespace Controllers;

use Models\Comments\Comment;
use Models\Users\User;
use View\View;
use Models\Articles\Article;

class CommentsController
{
    private $view;

    public function __construct() {
        $this->view = new View(__DIR__ . '/../../templates');
    }

    public function view(int $commentId) {
        $article = Article::getById($commentId);
        $comments = Comment::findAll();

        if ($comments === null) {
            $this->view->renderHtml('errors/404.php', [], 404);
            return;
        }

        $this->view->renderHtml('comments/show.php', ['article' => $article, 'comments' => $comments]);
    }

    public function edit(int $commentId): void {
        $comment = Comment::getById($commentId);
    
        if ($comment === null) {
            // Обработка случая, когда комментарий не найден
            $this->view->renderHtml('errors/404.php', [], 404);
            return;
        }
    
        $article = Article::getById($comment->getArticleId());
    
        $comment->setText($_POST['text']);
        $comment->save();
        header('Location: http://localhost/project/project/www/article/show/'.$article->getId());
    }
    

    public function add(): void {
        $author = User::getById(1);
    
        $pattern = '~comments/add/(\d+)~';
        preg_match($pattern, $_GET['route'], $matches);
    
        $article = Article::getById($matches[1]);
        $comment = new Comment();
    
        $comment->setAuthor($author);
        $comment->setArticle($article);
        $comment->setText($_POST["text"]);
    
        $comment->save();
    
        header('Location: http://localhost/project/project/www/article/show/'.$article->getId());
    }
    

    public function delete(int $id) {
        $comment = Comment::getById($id);
    
        if ($comment === null) {
            // Обработка случая, когда комментарий не найден
            $this->view->renderHtml('errors/404.php', [], 404);
            return;
        }
    
        // Получаем статью перед удалением комментария
        $article = Article::getById($comment->getArticleId());
    
        $comment->destroy();
    
        // После удаления перенаправляем пользователя на нужную страницу
        header("Location: http://localhost/project/project/www/article/show/{$article->getId()}");
        exit;
    }
    
    
}