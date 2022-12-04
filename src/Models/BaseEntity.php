<?php
declare(strict_types=1);

namespace App\Models;

use Exception;

class BaseEntity
{
    /**
     * @throws Exception
     */
    public function hydrate(array $data): void
    {
        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                if (is_string($value)) {
                    $this->$method($value);
                } else {
                    $this->$method(new \DateTime($value));
                }
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
