<?php

namespace App;

class Knight extends Item
{

    public function returnPossibleMovement(): array
    {
        return $this->filterPossibleMovementWithoutCollision($this->returnPossibleMovementWithoutFilter());
    }
    private function returnPossibleMovementWithoutFilter() {
        return [
            [
                'x' => chr(ord($this->x)-1),
                'y' => $this->y + 2
            ],
            [
                'x' => chr(ord($this->x)+1),
                'y' => $this->y + 2
            ],
            [
                'x' => chr(ord($this->x)-1),
                'y' => $this->y - 2
            ],
            [
                'x' => chr(ord($this->x)+1),
                'y' => $this->y - 2
            ],
            [
                'x' => chr(ord($this->x)+2),
                'y' => $this->y + 1
            ],
            [
                'x' => chr(ord($this->x)+2),
                'y' => $this->y - 1
            ],
            [
                'x' => chr(ord($this->x)-2),
                'y' => $this->y + 1
            ],
            [
                'x' => chr(ord($this->x)-2),
                'y' => $this->y - 1
            ],
        ];
    }

    public function returnPossibleEat(): array
    {
        return $this->filterEat($this->returnPossibleMovementWithoutFilter());
    }
}
