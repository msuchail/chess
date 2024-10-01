<?php

namespace App;

class Bishop extends Item
{
    use Diag;

    private array $diags;
    public function __construct(string $color, string $x, int $y, array $positions){
        parent::__construct($color, $x, $y, $positions);

        $this->diags = $this->getDiags($x, $y);
    }

    public function returnPossibleMovement(): array
    {
        return collect($this->diags)->map(function ($diag) {
            return $this->filterPossibleMovement($this->filterDiagOrLine($this->positions, $diag));
        })->flatten(1)->toArray();
    }

    public function returnPossibleEat(): array
    {
        return $this->filterEat(collect($this->diags)->map(function ($diag) {
            return collect($diag)->filter(fn($position) => isset($this->positions[$position['x']][$position['y']]))->first();
        })->filter()->toArray());
    }
}
