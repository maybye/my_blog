<?php

namespace Models\Articles;

use Models\Users\User;
use Models\ActiveRecordEntity;
use Models\Categories\Category;
use Models\Likes\Like;
use Services\Db;

class Article extends ActiveRecordEntity
{
    protected $authorId;
    protected $name;
    protected $text;
    protected $createdAt;
    protected $categoryId= 0; // Добавлено новое свойство для хранения ID категории
    protected $likes = 0;

    public function getText() {
        return $this->text;
    }

    public function getName() {
        return $this->name;
    }

    public function setName(string $name) {
        $this->name = $name;
    }

    public function setText(string $text) {
        $this->text = $text;
    }

    public function setAuthorId(User $author) {
        $this->authorId = $author->getId();
    }

    public function getAuthorId(): User {
        return User::getById($this->authorId);
    }

    public function getCategoryName(): string {
        $category = $this->getCategory();
        return $category ? $category->getName() : '';
    }

    // Метод для работы с категорией

    public function getCategory()
{
    // Проверяем, что $this->categoryId не является NULL перед вызовом getById()
    if ($this->categoryId !== null) {
        return Category::getById($this->categoryId);
    } else {
        return null; // Или можно вернуть какое-то значение по умолчанию, в зависимости от вашей логики
    }
}


    public function setCategoryId(Category $category): void
    {
        $this->categoryId = $category->getCategoryId();
    }
        

    protected static function getPrimaryKeyName(): string
    {
        return 'id'; 
    }
    
    protected static function getTableName(): string
    {
        return 'articles';
    }

    public function isLikedByUser(User $user): bool
{
    // Проверьте, поставил ли пользователь лайк этой статье
    $like = Like::findOneBy(['article_id' => $this->getId(), 'user_id' => $user->getId()]);

    return $like !== null;
}


public function like(User $user): void
{
    if (!$this->isLikedByUser($user)) {
        $like = new Like();
        $like->setArticleId($this->getId());
        $like->setUserId($user->getId());
        $like->save();
        $this->likes++;
        $this->save();
    } else {
        echo "User already liked this article.";
    }
}
    public function unlike(User $user): void
    {
        // Уберите лайк
        $like = Like::findOneBy(['article_id' => $this->getId(), 'user_id' => $user->getId()]);

        if ($like) {
            // $like->delete()
            if($this->likes>0){
                $this->likes--;
                $this->save();
            }
            else{
                $this->likes++  ;
                $this->save();
            }
             
        }
    }
    public function getLikesCount(): int
{
    if ($this->likes !== null) {
        return $this->likes;
    }

    // В противном случае, выполните запрос к базе данных
    $db = \Services\Db::getInstance();
    $result = $db->query('SELECT COUNT(*) as count FROM `likes` WHERE `article_id` = ?', [$this->getId()]);

    return $result && is_array($result) && isset($result[0]->count) ? (int)$result[0]->count : 0;
}
}
