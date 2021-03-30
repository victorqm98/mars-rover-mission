<?php

namespace App\ValueObjects;


use App\Obstacle;
use App\Rover;

class MapValueObject
{
    private array $cells;
    public const DIMENSION = 5;
    public const INITIAL_ROW = 0;
    public const INITIAL_COLUMN = 0;

    private function __construct(array $cells)
    {
        $this->cells = $cells;
    }

    public static function create(): MapValueObject
    {
        $cells = [];
        $dimension = self::DIMENSION;
        for ($row = 0; $row <= $dimension; $row++) {
            for ($column = 0; $column <= $dimension; $column++) {
                $coordinate = CoordinateValueObject::create($row, $column);
                $cells[] = CellValueObject::create($coordinate);
            }
        }

        return new self($cells);
    }

    public function putInitialRover(Rover $rover): CoordinateValueObject
    {
        $coordinate = CoordinateValueObject::create(self::INITIAL_ROW, self::INITIAL_COLUMN);
        $this->fillRover($coordinate, $rover);

        return $coordinate;
    }

    public function putInitialObstacle(Obstacle $obstacle): CoordinateValueObject
    {
        $coordinate = CoordinateValueObject::create(rand(0, self::DIMENSION), rand(0, self::DIMENSION));
        $this->fillObstacle($coordinate, $obstacle);

        return $coordinate;
    }

    private function fillRover(CoordinateValueObject $coordinate, Rover $rover): void
    {
        $this->find($coordinate)->fillRover($rover);
    }

    private function fillObstacle(CoordinateValueObject $coordinate, Obstacle $obstacle): void
    {
        $cell = $this->find($coordinate);
        if($cell->isEmptyObstacle() && $cell->isEmptyRover())
        {
            $cell->fillObstacle($obstacle);
        }
    }

    public function find(CoordinateValueObject $coordinate): CellValueObject
    {
        assert($coordinate->isValid(self::DIMENSION));

        /** @var CellValueObject $cell */
        foreach ($this->cells as $cell) {
            if ($cell->inCoordinate($coordinate)) {
                return $cell;
            }
        }

        assert(false);
    }

    public function move($action): CoordinateValueObject
    {
        /** @var CellValueObject $cell */
        foreach ($this->cells as $cell) {
            if (!$cell->hasRover()) {
                continue;
            }

            $origin = $cell->coordinate();
            $rover = $this->empty($origin);

            $target = $this->actionSwitch($action, $origin);

            if(!$target->isValid(self::DIMENSION)) {
                throw new \Exception('Movement not valid this cell not exists!');
            }
            $cellTarget = $this->find($target);

            if(!$cellTarget->isEmptyObstacle()){
                throw new \Exception('Movement not valid in this cell are a obstacle!');
            }

            $this->fillRover($target, $rover);

            return $target;
        }
    }

    public function actionSwitch(ActionValueObject $action, CoordinateValueObject $origin): CoordinateValueObject
    {
        switch ($action->value()) {
            case "R":
                $target = $this->createCoordinateLocal($origin->row(), $origin->column() + 1);
                break;
            case "L":
                $target = $this->createCoordinateLocal($origin->row(), $origin->column() - 1);
                break;
            case "F":
                $target = $this->createCoordinateLocal($origin->row() + 1, $origin->column());
                break;
            default:
                throw new \InvalidArgumentException('Movement not valid!');
        }
        return $target;
    }

    private function createCoordinateLocal(int $row, int $column): CoordinateValueObject
    {
        return CoordinateValueObject::create($row, $column);
    }

    private function empty(CoordinateValueObject $coordinate): Rover
    {
        return $this->find($coordinate)->empty();
    }

}
