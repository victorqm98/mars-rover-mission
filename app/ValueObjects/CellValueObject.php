<?php


namespace App\ValueObjects;

use App\Obstacle;
use App\Rover;

class CellValueObject
{
    private CoordinateValueObject $coordinate;
    private ?Rover $rover = null;
    private ?Obstacle $obstacle = null;

    function __construct(CoordinateValueObject $coordinate)
    {
        $this->coordinate = $coordinate;
    }

    public static function create($coordinate): CellValueObject
    {
        return new self($coordinate);
    }

    public function coordinate(): CoordinateValueObject
    {
        return $this->coordinate;
    }

    public function inCoordinate(CoordinateValueObject $coordinate): bool
    {
        return $this->coordinate->equals($coordinate);
    }

    private function rover(): Rover
    {
        return $this->rover;
    }

    public function fillRover(?Rover $rover): void
    {
        $this->rover = $rover;
    }

    public function fillObstacle(?Obstacle $obstacle): void
    {
        $this->obstacle = $obstacle;
    }

    public function empty(): Rover
    {
        $rover          = $this->rover();
        $this->rover    = null;
        return $rover;
    }

    public function hasRover(): bool
    {
        return isset($this->rover);
    }

    private function hasObstacle(): bool
    {
        return isset($this->obstacle);
    }

    public function isEmptyRover(): bool
    {
        return !$this->hasRover();
    }

    public function isEmptyObstacle(): bool
    {
        return !$this->hasObstacle();
    }
}
