<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Db;
use PDOStatement;


class Repository extends BaseEntity
{
    /**
     * Execute a database query and return the resulting statement.
     *
     * @param string $query The query to execute.
     * @param array $params An array of parameters to bind to the query.
     * @return PDOStatement The resulting statement.
     */
    public function request(string $query, array $params = []): PDOStatement
    {
        $db = Db::getInstance();
        $statement = $db->prepare($query);
        $statement->execute($params);
        return $statement;
    }

    /**
     * Get the name of the database table corresponding to the repository model.
     *
     * The name of the table is derived from the name of the model class, with the "Repository" suffix removed.
     *
     * @return array|string The name of the table.
     */
    private function getTable(): array|string
    {
        $table = explode('\\', get_class($this));
        $table = strtolower(end($table));
        return str_replace('repository', '', $table);
    }

    /**
     * Save an object to the database.
     *
     * @param object $object The object to save.
     * @return PDOStatement Statement The resulting statement.
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
     * Retrieve all rows from the database table.
     *
     * @return array An array of rows from the table.
     */
    public function fetchAll(): array
    {
        $table = $this->getTable();
        $stmt = $this->request("SELECT *, DATE_FORMAT(createdAt, '%d/%m/%Y at %Hh%i') AS created_fr, DATE_FORMAT(updatedAt, '%d/%m/%Y at %Hh%i') AS updated_fr FROM $table ORDER BY createdAt DESC");
        return $stmt->fetchAll();
    }

    /**
     * Retrieve a row from the database table by its primary key.
     *
     * @param int $id The primary key of the row to retrieve.
     * @return mixed The row from the table.
     */
    public function fetch(int $id): mixed
    {
        $table = $this->getTable();
        return $this->request("SELECT *, DATE_FORMAT(createdAt, '%d/%m/%Y at %Hh%i') AS created_fr, DATE_FORMAT(updatedAt, '%d/%m/%Y at %Hh%i') AS updated_fr FROM $table WHERE id = ?", [$id])->fetch();
    }

    /**
     * Retrieve rows from the database table by matching a field and its value.
     *
     * @param array $params An array of field-value pairs to match.
     * @return bool|array The resulting rows, or false if no rows were found.
     */
    public function fetchBy(array $params): bool|array
    {
        $table = $this->getTable();

        $fields = array_map(function ($field) {
            return "$field = :$field";
        }, array_keys($params));

        $fields_list = implode(' AND ', $fields);
        $query = $this->request("SELECT *, DATE_FORMAT(createdAt, '%d/%m/%Y at %Hh%i') AS created_fr, DATE_FORMAT(updatedAt, '%d/%m/%Y at %Hh%i') AS updated_fr FROM $table WHERE $fields_list ORDER BY createdAt DESC", $params);
        return $query->fetchAll();
    }

    /**
     * Retrieve a row from the database table by matching a single field and its value.
     *
     * @param string $field The field to match.
     * @param string $value The value to match.
     * @return mixed The resulting row.
     */
    public function fetchOneBy(string $field, string $value): mixed
    {
        $table = $this->getTable();
        return $this->request("SELECT * FROM $table WHERE $field = ?", [$value])->fetch();
    }

    /**
     * Update a row in the database table by its primary key.
     *
     * @param object $object The object containing the new field values.
     * @param int $id The primary key of the row to update.
     * @return PDOStatement Statement The statement object resulting from the query.
     */
    public function update(object $object, int $id): PDOStatement
    {
        $table = $this->getTable();

        // We get the properties of the object
        $properties = $object->getProperties();

        // We create an array with the fields to update
        $updateFields = array_map(function ($field): string {
            return "$field = :$field";
        }, array_keys($properties));

        // We transform the updateFields array into a string
        $updateFieldsString = implode(', ', $updateFields);

        // We add the id field to the properties array
        $properties['id'] = $id;

        // We prepare the query
        return $this->request("UPDATE $table SET $updateFieldsString WHERE id = :id", $properties);

    }

    /**
     * Update a single field of a row in the database table by its primary key.
     *
     * @param string $field The name of the field to update.
     * @param string|int $value The new value for the field.
     * @param string $params The primary key of the row to update.
     * @return PDOStatement Statement The statement object resulting from the query.
     */
    public function updateOneBy(string $field, string|int $value, string $params): PDOStatement
    {
        $table = $this->getTable();
        return $this->request("UPDATE $table SET $field = ? WHERE id = ?", [$value, $params]);
    }

    /**
     * Delete a row from the database table by its primary key.
     *
     * @param int $id The primary key of the row to delete.
     * @return PDOStatement Statement The statement object resulting from the query.
     */
    public function delete(int $id): PDOStatement
    {
        $table = $this->getTable();
        return $this->request("DELETE FROM $table WHERE id = ?", [$id]);
    }
}
