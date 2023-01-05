<?php
declare(strict_types=1);

namespace App\Models;

use DateTime;
use Exception;

class BaseEntity
{
    /**
     * Hydrate the entity with the given data
     *
     * @param array $data The data to hydrate the entity with
     * @return void
     * @throws Exception
     */
    public function hydrate(array $data): void
    {
        foreach ($data as $key => $value) {
            $setterMethod = 'set' . ucfirst($key);
            if (method_exists($this, $setterMethod)) {
                if (in_array($key, ['createdAt', 'updatedAt']) && !($value instanceof DateTime) && $value !== null) {
                    $value = new DateTime($value);
                }
                $this->$setterMethod($value);
            }
        }
    }

    /**
     * Get the entity as an array
     *
     * @return array
     */
    public function getProperties(): array
    {
        return get_object_vars($this);
    }
}
