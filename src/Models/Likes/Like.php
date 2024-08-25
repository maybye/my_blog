<?php

namespace Models\Likes;

use Models\ActiveRecordEntity;
use Services\Db;

class Like extends ActiveRecordEntity
{
    protected int $like_id= 0;
    protected int $article_id;
    protected int $user_id;


    public function getLikeId(): int
    {
        return $this->like_id;
    }

    public function getArticleId(): int
    {
        return $this->article_id;
    }

    public function setArticleId(int $articleId): void
    {
        $this->article_id = $articleId;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function setUserId(int $userId): void
    {
        $this->user_id = $userId;
    }

    protected static function getTableName(): string
    {
        return 'likes';
    }

    public static function findOneBy(array $conditions): ?self
{
    $db = Db::getInstance();

    $sql = 'SELECT * FROM `' . static::getTableName() . '` WHERE ';

    foreach ($conditions as $column => $value) {
        $param = ':' . $column;
        $sql .= "`$column` = $param AND ";
    }

    $sql = rtrim($sql, ' AND ');

    $sql .= ' LIMIT 1';

    $result = $db->query($sql, $conditions, static::class);

    $data = $result ? reset($result) : null;

    return $data ? static::createFromObject($data) : null;
}


}
