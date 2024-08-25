<?php

namespace Models\Comments;

use Models\Users\User;
use Models\ActiveRecordEntity;
use Models\Articles\Article;

class Comment extends ActiveRecordEntity
{
    protected $author_id;
    protected $article_id;
    protected $text;
    protected $date;

    public function setText(string $text) {
        $this->text = $text;
    }

    public function getText(): string {
        return $this->text;
    }

    public function setAuthor(User $author): void {
        $this->author_id = $author->getId();
    }

    public function setArticle(Article $article): void {
        $this->article_id = (int) $article->getId();  // Приведение типа и исправление имени свойства
    }

    public function getArticleId(): int {
        return $this->article_id;  // Возвращение значения свойства
    }

    protected static function getTableName(): string {
        return 'comments';
    }
    protected static function getPrimaryKeyName(): string
    {
        return 'id'; // Замените на имя вашего первичного ключа
    }
}
