<?php


namespace App;


use App\ValueObjects\UuidValueObject;

class Obstacle
{
    private UuidValueObject $id;

    private function __construct(UuidValueObject $id)
    {
        $this->id = $id;
    }

    public static function create(): Obstacle
    {
        return new self(UuidValueObject::generateUuid());
    }
}
