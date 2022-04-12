<?php

/** User: MoAdel ... */

namespace app\core\db;

use app\core\Application;
use app\core\Model;

/**
 * Class BbModel
 * 
 * @author Mohamed-Adel-work <mohamed.wemail@gmail.com>
 * @package app\core
 * 
 */
abstract class DbModel extends Model
{
    abstract public static function tableName(): string;
    abstract public function attributes(): array;
    abstract public static function primaryKey(): string;


    public function save()
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $params = array_map(fn($attr) => ":$attr", $attributes);
        $statement = self::prepare("INSERT INTO $tableName (" . implode(",", $attributes) . ") 
                VALUES (" . implode(",", $params) . ")");
        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }
        $statement->execute();
        return true;
    }

    public static function findOne($where) // [email => mohamed@example.com, firstname => mohamed]
    {
        $tableName = static::tableName();
        $attributes = array_keys($where);
        // array_map(fn($attr) => "$attr" = ":$attr", $attributes);

        $sql = implode("AND", array_map(function ($attr) {
            return "$attr = :$attr";
        }, $attributes));

        $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");
        foreach ($where as $key => $item) {
            $statement->bindValue(":$key", $item);
        }
        $statement->execute();
        return $statement->fetchObject(static::class);
    }

    public static function prepare($sql)
    {
        return Application::$app->db->pdo->prepare($sql);
    }
}
