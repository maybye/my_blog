<?php

namespace Models;

use Models\Users\User;
use Services\Db;

abstract class ActiveRecordEntity
{
    protected $id = null;
    protected $createdAt;
    // protected $authToken;
    // protected $role;
    // protected $isConfirmed;

    public function getId()
    {

        return $this->id;
    }
    public function __setId($id)
    {
        $this->id = $id;
    }
    public function __set($name, $value)
    {
        $camelCaseName = $this->underScoreToCamelCase($name);
        $this->$camelCaseName = $value;
    }

    private function underScoreToCamelCase(string $str)
    {
        return lcfirst(str_replace('_', '', ucwords($str, '_')));
    }

    private function camelCaseToUnderscore(string $source): string
    {
        return strtolower(preg_replace('/([A-Z])/', '_$1', $source));
    }

    private function mapPropertiesToDbFormat(): array
    {

        $reflector = new \ReflectionObject($this);
        $properties = $reflector->getProperties();
        $mappedProperties = [];
        foreach ($properties as $property) {
            $propertyName = $property->getName();
            $propertyToDbFormat = $this->camelCaseToUnderscore($propertyName);
            $mappedProperties[$propertyToDbFormat] = $this->$propertyName;
        }
        return $mappedProperties;
    }

    public function save()
    {
        $mappedProperties = $this->mapPropertiesToDbFormat();
        if ($mappedProperties['id'] !== null) {
            $this->update($mappedProperties);
        } else
            $this->insert($mappedProperties);
    }

    public function update(array $mappedProperties)
    {
        $db = Db::getInstance();
        $column2params = [];
        $params2values = [];
        $index = 1;
        foreach ($mappedProperties as $column => $value) {
            $param = ':param' . $index;
            $column2params[] = $column . '=' . $param;
            $params2values[$param] = $value;
            $index++;
        }
        $sql = 'UPDATE `' . static::getTableName() . '` SET ' . implode(',', $column2params) . ' WHERE id=' . $this->id;
        $db->query($sql, $params2values, static::class);
    }

    public function insert(array $mappedProperties)
    {
        $db = Db::getInstance();
        $filteredProperties = array_filter($mappedProperties);
        $columns = [];
        $column2params = [];
        $params2values = [];
        foreach ($filteredProperties as $column => $value) {
            $columns[] = '`' . $column . '`';
            $paramName = ':' . $column;
            $column2params[] = $paramName;
            $params2values[$paramName] = $value;
        }
        $sql1 = 'INSERT INTO `' . static::getTableName() . '` (' . implode(',', $columns) . ') VALUES (' . implode(',', $column2params) . ')';
        $db->query($sql1, $params2values, static::class);
        $this->id = $db->lastInsertId();
    }

    public static function lastInsertId(): int
    {
        $sql = "SELECT LAST_INSERT_ID() AS `lastId`";
        $db = Db::getInstance();
        $result = $db->query($sql, [], static::class);
        return $result[0]->lastId;
    }

    public static function createFromData(array $data): ?self
    {
        $user = new self();
        foreach ($data as $key => $value) {
            $camelCaseKey = $user->underScoreToCamelCase($key);
            $user->$camelCaseKey = $value;
        }
    
        return $user;
    }
    
    public static function createFromObject($object): ?self
    {
        if (!is_object($object)) {
            return null;
        }

        $entity = new static();

        foreach ($object as $key => $value) {
            $camelCaseKey = $entity->underScoreToCamelCase($key);
            $entity->$camelCaseKey = $value;
        }

        return $entity;
    }
    
    public static function findOne(array $conditions): ?self
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
     
        return $data;
        return $data ? static::createFromData($data) : null;
    }
    


    public static function findAll(): ?array
    {
        $db = Db::getInstance();
        return $db->query('SELECT * FROM `' . static::getTableName() . '`', [], static::class);
    }

   // В классе ActiveRecordEntity
public static function getById(int $id)
{
    $db = Db::getInstance();
    $primaryKeyName = static::getPrimaryKeyName(); // получаем имя первичного ключа

    $entities = $db->query('SELECT * FROM `' . static::getTableName() . '` WHERE `' . $primaryKeyName . '` = :id', [':id' => $id], static::class);

    return $entities ? $entities[0] : null;
}


    public function destroy()
    {
        $db = Db::getInstance();
        $sql = 'DELETE FROM `' . static::getTableName() . '` WHERE id=:id';
        $db->query($sql, [':id' => $this->id], static::class);
        $this->id = null;
    }
    

    abstract protected static function getTableName(): string;

}