<?php


namespace App;


use App\ValueObjects\UuidValueObject;

class Rover
{
    private UuidValueObject $id;

    private function __construct(UuidValueObject $id)
    {
        $this->id = $id;
    }

    public static function create(): Rover
    {
        return new self(UuidValueObject::generateUuid());
    }
}
