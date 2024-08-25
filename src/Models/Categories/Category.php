<?php

namespace Models\Categories;

use Models\ActiveRecordEntity;
use Services\Db;

class Category extends ActiveRecordEntity 
{
    protected string $name;
    protected int $category_id = 0;

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    protected static function getTableName(): string {
        return 'categories';
    }

    protected static function getPrimaryKeyName(): string {
        return 'category_id';
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

        return $result ? reset($result) : null;
    }


    public function getCategoryId(): int {
        return $this->category_id;
    }

    // Один вариант
    public static function createFromDataArray(array $data): self
    {
        $category = new self();
        foreach ($data as $key => $value) {
            $category->{$key} = $value;
        }
        return $category;
    }

    // Второй вариант
    public static function createFromDataObject(self $data): self
    {
        return $data;
    }


    public static function createFromData(array $data): self
    {
        $category = new self();
        foreach ($data as $key => $value) {
            $category->{$key} = $value;
        }
        return $category;
    }

    

}
 