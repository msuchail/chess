<?php

namespace App;

class Queen extends Item
{
    use Diag;
    use Line;

    private array $diags;
    private array $lines;


    public function __construct(string $color, string $x, int $y, array $positions){
        parent::__construct($color, $x, $y, $positions);

        $this->diags = $this->getDiags($x, $y);
        $this->lines = $this->getLines($x, $y);
    }

    public function returnPossibleMovement(): array
    {
        $possibleMovements = collect();


        $possibleMovements->push(collect($this->diags)->map(function ($diag) {
            return $this->filterPossibleMovement($this->filterDiagOrLine($this->positions, $diag));
        })->flatten(1)->toArray());

        $possibleMovements->push(collect($this->lines)->map(function ($line) {
            return $this->filterPossibleMovement($this->filterDiagOrLine($this->positions, $line));
        })->flatten(1)->toArray());

        return $possibleMovements->flatten(1)->toArray();
    }



    public function returnPossibleEat(): array
    {
        $possibleEat = collect();

        $possibleEat->push($this->filterEat(collect($this->diags)->map(function ($diag) {
            return collect($diag)->filter(fn($position) => isset($this->positions[$position['x']][$position['y']]))->first();
        })->filter()->toArray()));

        $possibleEat->push($this->filterEat(collect($this->lines)->map(function ($diag) {
            return collect($diag)->filter(fn($position) => isset($this->positions[$position['x']][$position['y']]))->first();
        })->filter()->toArray()));

        return $possibleEat->flatten(1)->toArray();
    }
}
