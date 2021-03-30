<?php


namespace App\ValueObjects;

class ActionValueObject
{
    private string $action;

    const ACTIONS_ALLOWED = ['F','L', 'R'];

    private function __construct(string $action)
    {
        $this->guardAgainstInvalidArguments($action);
        $this->action = $action;
    }

    public static function fromString(string $value): ActionValueObject
    {
        return new self($value);
    }

    public function value(): string
    {
        return $this->action;
    }

    private function guardAgainstInvalidArguments(string $action): void
    {
        if(!in_array($action, self::ACTIONS_ALLOWED)){
            throw new \InvalidArgumentException('Action not valid');
        }
    }
}
