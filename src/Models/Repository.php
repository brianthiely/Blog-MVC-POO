<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Db;
use PDOStatement;


class Repository extends BaseEntity
{
    /**
     * @param string $query
     * @param array $params
     * @return PDOStatement
     */
    public function request(string $query, array $params = []): PDOStatement
    {
        $db = Db::getInstance();
        $statement = $db->prepare($query);
        $statement->execute($params);
        return $statement;
    }

    /**
     * @return array|string
     */
    private function getTable(): array|string
    {
        $table = explode('\\', get_class($this));
        $table = strtolower(end($table));
        return str_replace('repository', '', $table);
    }

    /**
     * @param object $object
     * @return PDOStatement
     */
    public function save(object $object): PDOStatement
    {
        $table = $this->getTable();

        // We get the properties of the object
        $properties = $object->getProperties();

        // Retrieve the keys of the array
        $fields = array_keys($properties);

        // On transforme le tableau "champs" en une chaine de caractères
        $fields_list = implode(', ', $fields);

        // On transforme le tableau "valeurs" en une chaine de caractères
        $values_list = implode(', ', array_map(function ($field) {
            return ":$field";
        }, $fields));

        // On prépare la requête
        return $this->request("INSERT INTO $table ($fields_list) VALUES ($values_list)", $properties);
    }

    /**
     * @return array
     */
    public function fetchAll(): array
    {
        $table = $this->getTable();
        $stmt = $this->request("SELECT *, DATE_FORMAT(createdAt, '%d/%m/%Y at %Hh%i') AS created_fr, DATE_FORMAT(updatedAt, '%d/%m/%Y at %Hh%i') AS updated_fr FROM $table ORDER BY createdAt DESC");
        return $stmt->fetchAll();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function fetch(int $id): mixed
    {
        $table = $this->getTable();
        return $this->request("SELECT *, DATE_FORMAT(createdAt, '%d/%m/%Y at %Hh%i') AS created_fr, DATE_FORMAT(updatedAt, '%d/%m/%Y at %Hh%i') AS updated_fr FROM $table WHERE id = ?", [$id])->fetch();
    }

    /**
     * @param array $params
     * @return bool|array
     */
    public function fetchBy(array $params): bool|array
    {
        $table = $this->getTable();

        // On récupère les clés du tableau
        $fields = array_map(function ($field) {
            return "$field = :$field";
        }, array_keys($params));

        // On transforme le tableau "champs" en une chaine de caractères
        $fields_list = implode(' AND ', $fields);

        // On prépare la requête en ordre decroissant
        $query = $this->request("SELECT *, DATE_FORMAT(createdAt, '%d/%m/%Y at %Hh%i') AS created_fr, DATE_FORMAT(updatedAt, '%d/%m/%Y at %Hh%i') AS updated_fr FROM $table WHERE $fields_list ORDER BY createdAt DESC", $params);

        return $query->fetchAll();
    }

}
