<?php


namespace App\ValueObjects;

use Ramsey\Uuid\Uuid;

class UuidValueObject
{
    private string $id;

    private function __construct(string $id)
    {
        if(!Uuid::isValid($id)){
            throw new \InvalidArgumentException('Uuid not valid');
        }

        $this->id = $id;
    }

    public static function generateUuid(): UuidValueObject
    {
        $uuid = Uuid::uuid4();
        return new self($uuid->toString());
    }

    public static function fromString(string $value): UuidValueObject
    {
        return new self($value);
    }

    public function value(): string
    {
        return $this->id;
    }
}
