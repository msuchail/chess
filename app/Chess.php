<?php

namespace App;

trait Chess
{
    use Instanciate;
    protected function isChess($positions, $lastMoves, $color): string|null
    {
        $opositeColor = $color === 'white' ? 'black' : 'white';
        $kingPosition = [];
        collect($positions)
            ->each(function ($postion, $x) use ($color, $opositeColor, &$kingPosition) {
                collect($postion)
                    ->each(function ($item, $y) use ($x, $color, $opositeColor, &$kingPosition) {
                        if($item === $color.'-king') {
                            $kingPosition = [
                                'x' => $x,
                                'y' => $y,
                            ];
                            return false;
                        }
                        return true;
                    });
                return (empty($kingPosition));
            })->flatten()->contains(true);

        $chess = false;
        collect($positions)
            ->each(function ($line, $x) use ($opositeColor, $positions, $lastMoves, $color,  $kingPosition, &$chess) {
                return collect($line)
                    ->each(function ($item, $y) use ($opositeColor, $positions, $lastMoves, $x, $color, $kingPosition, &$chess) {
                        if(str_contains($item, $opositeColor)) {
                            $item = $this->getInstance($positions, $x, $y, $color, $lastMoves);
                            $possibleEat = $item->returnPossibleEat();

                            if(
                                collect($possibleEat)
                                    ->filter(fn($eat) => $eat['x'] === $kingPosition['x'] && $eat['y'] === $kingPosition['y'])
                                    ->isNotEmpty())
                            {
                                $chess = true;
                            }
                            return !$chess;
                        } else return !$chess;
                    });
            }
            )->flatten()->contains(true);
        return $chess;
    }
}
