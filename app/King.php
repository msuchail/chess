<?php

namespace App;

//TODO : implementer la notion d'échec et de clouage et mat
class King extends Item
{


    public function returnPossibleMovement(): array
    {
        return $this->filterPossibleMovement($this->returnPossibleMovementWithoutFilter());
    }

    public function returnPossibleMovementWithoutFilter(): array
    {
        return [
            [
                'x' => chr(ord($this->x) +1 ),
                'y' => $this->y
            ],
            [
                'x' => chr(ord($this->x) +1 ),
                'y' => $this->y+1
            ],
            [
                'x' => chr(ord($this->x) +1 ),
                'y' => $this->y-1
            ],
            [
                'x' => chr(ord($this->x) - 1 ),
                'y' => $this->y
            ],
            [
                'x' => chr(ord($this->x) - 1 ),
                'y' => $this->y+1
            ],
            [
                'x' => chr(ord($this->x) - 1 ),
                'y' => $this->y-1
            ],
            [
                'x' => $this->x,
                'y' => $this->y-1
            ],
            [
                'x' => $this->x,
                'y' => $this->y+1
            ]
        ];
    }

    public function returnPossibleEat(): array
    {
        return $this->filterEat($this->returnPossibleMovement());
    }
}
