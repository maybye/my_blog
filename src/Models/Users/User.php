<?php

namespace Models\Users;

use Models\ActiveRecordEntity;
use Services\Db;

class User extends ActiveRecordEntity
{
    protected $nickname;
    protected $email;
    protected $passwordHash;

    public function getNickname(): string
    {
        return $this->nickname ?? '';
    }

    public function getEmail(): string
    {
        return $this->email ?? '';
    }

    public function getId(): int
    {
        return $this->id ?? 3;
    }


    public function getPasswordHash(): string
    {
        return $this->passwordHash ?? '';
    }

    public static function getByNickName(string $nickname): ?User
    {
        $db = Db::getInstance();
        $entities = $db->query('SELECT * FROM `' . static::getTableName() . '` WHERE `nickname` = :nickname', [':nickname' => $nickname], static::class);
        return $entities ? $entities[0] : null;
    }

    public static function getById(int $id): ?User
    {
        $db = Db::getInstance();
        $entities = $db->query('SELECT * FROM `' . static::getTableName() . '` WHERE `id` = :id', [':id' => $id], static::class);
        return $entities ? $entities[0] : null;
    }

    public function setNickName(string $nickname): void
    {
        $this->nickname = $nickname;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setPasswordHash(string $passwordHash): void
    {
        $this->passwordHash = $passwordHash;
    }

    protected static function getTableName(): string
    {
        return 'users';
    }

    public static function createFromData($data): ?User
    {
        if (empty($data)) {
            return null;
        }

        if (is_object($data)) {
            $data = get_object_vars($data);
        }

        $user = new self();

        foreach ($data as $key => $value) {
            $setterMethod = 'set' . ucfirst($key);

            if (method_exists($user, $setterMethod)) {
                $user->$setterMethod($value);
            }
        }

        return $user;
    }

}
