<?php

namespace App;

abstract class Item
{
    /**
     * @param string $color
     * @param string $x
     * @param string $y
     * @param array $positions
     */
    public function __construct(
        public string $color,
        public string $x,
        public int $y,
        public array $positions,
    ){}
    public abstract function returnPossibleMovement():array;
    protected function filterPossibleMovementWithoutCollision(array $possibleMovement):array
    {
        return collect($possibleMovement)->filter(function ($item) {
            //On vérifie qu'on ne sort pas de l'échéquier
            if (ord($item['x'])<ord("A") | ord($item['x'])>ord("H") | $item['y']<1 |  $item['y']>8) {
                return false;
            }

            //On vérifie que la case n'est pas occupée par une pièce
            if (isset($this->positions[$item['x']][$item['y']])) {
                return false;
            }

            return true;
        })->toArray();
    }

    protected function filterPossibleMovement(array $possibleMovement):array
    {
        $return = [];

        foreach ($possibleMovement as $movement) {
            if (!isset($this->positions[$movement['x']][$movement['y']])) {
                $return[] = $movement;
            }
        }

        return $return;
    }

    public abstract function returnPossibleEat():array;

    protected function filterEat(array $possibleEat): array
    {
        return collect($possibleEat)->filter(function ($item) {

            //On vérifie si présence d'énnemi sur la case
            if (isset($this->positions[$item['x']][$item['y']]) && explode('-', $this->positions[$item['x']][$item['y']])[0] !== $this->color) {
                return true;
            }

            return false;
        })->toArray();
    }

    public function filterDiagOrLine(array $positions, array $diagOrRow)
    {
        $filteredDiag = [];
        $i=0;
        while (isset($diagOrRow[$i]) && !isset($positions[$diagOrRow[$i]['x']][$diagOrRow[$i]['y']])) {
            $filteredDiag[] = $diagOrRow[$i];
            $i++;
        }
        return $filteredDiag;
    }
}
