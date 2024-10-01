<?php

namespace App;

trait Instanciate
{
    protected function getInstance($positions, $x, $y, $color, $lastMoves) : Item|null
    {
        switch (explode('-', $positions[$x][$y])[1]) {
            case 'pawn':
                $item = new Pawn($color, $x, $y, $positions, $lastMoves);
                break;
            case 'knight':
                $item = new Knight($color, $x, $y, $positions);
                break;
            case 'bishop':
                $item = new Bishop($color, $x, $y, $positions);
                break;
            case 'rock':
                $item = new Rock($color, $x, $y, $positions);
                break;
            case 'king':
                $item = new King($color, $x, $y, $positions);
                break;
            case 'queen':
                $item = new Queen($color, $x, $y, $positions);
        }
        return $item ?? null;
    }
}
