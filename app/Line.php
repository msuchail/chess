<?php

namespace App;

trait Line
{
    public function getLines(string $x, int $y)
    {
        $lines=[];

        //droite
        $iterateX = ord($x);
        while($iterateX < ord("H")) {
            $iterateX++;
            $lines[0][] = [
                "x" => chr($iterateX),
                "y" => $y,
            ];
            $lines[0] = collect($lines[0] ?? [])->sortBy('x')->toArray();
        }

        //gauche
        $iterateX = ord($x);
        while($iterateX > ord("A")) {
            $iterateX--;
            $lines[1][] = [
                "x" => chr($iterateX),
                "y" => $y,
            ];
            $lines[1] = collect($lines[1] ?? [])->sortByDesc('x')->toArray();
        }

        //haut
        $iterateY=$y;
        while($iterateY < 8) {
            $iterateY++;
            $lines[2][] = [
                "x" => $x,
                "y" => $iterateY,
            ];

            $lines[2] = collect($lines[2] ?? [])->sortBy('y')->toArray();
        }

        //bas
        //haut
        $iterateY=$y;
        while($iterateY > 1) {
            $iterateY--;
            $lines[3][] = [
                "x" => $x,
                "y" => $iterateY,
            ];

            $lines[3] = collect($lines[3] ?? [])->sortByDesc('y')->toArray();
        }
        return $lines;
    }
}
