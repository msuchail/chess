<?php

namespace App;

use Illuminate\Support\Collection;

class Pawn extends Item
{
    private Collection $lastMoves;

    public function __construct(string $color, string $x, int $y, array $positions, array $lastMoves){
        parent::__construct($color, $x, $y, $positions);

        $this->lastMoves = collect($lastMoves);
    }

    public function returnPossibleMovement():array
    {
        $possibleMovements = [];
        $lastMove = $this->lastMoves->flatten(1)->last();
        if($this->color==="white") {
            $possibleMovements =
                [
                    [
                        'x' => $this->x,
                        'y' => $this->y+1,
                    ]
                ];
            if($this->y === 2) {
                $possibleMovements[] = [
                    'x' => $this->x,
                    'y' => $this->y+2,
                ];
            }

            //prise en passant
            if(
                $this->y === 5 &&
                $lastMove['item'] === 'black-pawn' &&
                $lastMove['from']['y'] === 7 &&
                $lastMove['to']['y'] === 5 &&
                (
                    ord($lastMove['from']['x']) ===  ord($this->x)+1 ||
                    ord($lastMove['to']['x']) ===  ord($this->x)-1
                )
            ) {
                $possibleMovements[] = [
                    'x' => $lastMove['to']['x'],
                    'y' => 6
                ];
            }
        } elseif($this->color==="black") {
            $possibleMovements =
            [
                [
                    'x' => $this->x,
                    'y' => $this->y-1,
                ]
            ];
            if($this->y === 7) {
                $possibleMovements[] = [
                    'x' => $this->x,
                    'y' => $this->y-2,
                ];
            }
            //prise en passant
            if(
                $this->y === 4 &&
                $lastMove['item'] === 'white-pawn' &&
                $lastMove['from']['y'] === 2 &&
                $lastMove['to']['y'] === 4 &&
                (
                    ord($lastMove['from']['x']) ===  ord($this->x)+1 ||
                    ord($lastMove['to']['x']) ===  ord($this->x)-1
                )
            ) {
                $possibleMovements[] = [
                    'x' => $lastMove['to']['x'],
                    'y' => 3
                ];
            }
        }
        return $this->filterPossibleMovement($possibleMovements);
    }

    public function returnPossibleEat(): array
    {
        if ($this->color === "white") {
            $possibleEat = [
                [
                    'x' => chr(ord($this->x)-1),
                    'y' => $this->y+1,
                ],
                [
                    'x' => chr(ord($this->x)+1),
                    'y' => $this->y+1,
                ]
            ];
        } else {
            $possibleEat = [
                [
                    'x' => chr(ord($this->x)-1),
                    'y' => $this->y-1,
                ],
                [
                    'x' => chr(ord($this->x)+1),
                    'y' => $this->y-1,
                ]
            ];
        }

        return $this->filterEat($possibleEat);
    }
}
