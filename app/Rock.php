<?php

namespace App;

class Rock extends Item
{
    use Line;

    private array $lines;

    public function __construct(string $color, string $x, int $y, array $positions){
        parent::__construct($color, $x, $y, $positions);

        $this->lines = $this->getLines($x, $y);
    }

    public function returnPossibleMovement(): array
    {
        return collect($this->lines)->map(function ($line) {
            return $this->filterPossibleMovement($this->filterDiagOrLine($this->positions, $line));
        })->flatten(1)->toArray();
    }

    public function returnPossibleEat(): array
    {
        return $this->filterEat(collect($this->lines)->map(function ($diag) {
            return collect($diag)->filter(fn($position) => isset($this->positions[$position['x']][$position['y']]))->first();
        })->filter()->toArray());
    }
}
