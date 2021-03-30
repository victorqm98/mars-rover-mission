<?php


namespace App\ValueObjects;


class CoordinateValueObject
{
    private int $row;
    private int $column;

    function __construct(int $row, int $column)
    {
        $this->row      = $row;
        $this->column   = $column;
    }

    public function row(): int
    {
        return $this->row;
    }

    public function column(): int
    {
        return $this->column;
    }

    public static function create(int $row, int $column): CoordinateValueObject
    {
        return new self($row, $column);
    }

    public function isValid(int $dimension): bool
    {
        $column = $this->column();
        $row    = $this->row();

        return $column < $dimension && $column >= 0 && $row < $dimension && $row >= 0;
    }

    public function sameRow(self $coordinate): bool
    {
        return $this->row() == $coordinate->row();
    }

    public function sameColumn(self $coordinate): bool
    {
        return $this->column() == $coordinate->column();
    }

    public function equals(self $coordinate): bool
    {
        return $this->sameRow($coordinate) && $this->sameColumn($coordinate);
    }
}
