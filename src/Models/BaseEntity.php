<?php
declare(strict_types=1);

namespace App\Models;

use DateTime;
use Exception;

class BaseEntity
{
    /**
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
     * @return array
     */
    public function getProperties(): array
    {
        return get_object_vars($this);
    }
}
