<?php

namespace App;

trait Diag
{
    public function getDiags(string $x, int $y)
    {
        $diags=[];


        $iterateX = ord($x);
        $iterateY = $y;
        while($iterateX < ord("H") && $iterateY < 8) {
            $iterateX++;
            $iterateY++;
            $diags[0][] = [
                "x" => chr($iterateX),
                "y" => $iterateY,
            ];
            $diags[0] = collect($diags[0] ?? [])->sortBy('y')->toArray();
        }

        $iterateX = ord($x);
        $iterateY = $y;
        while($iterateX > ord("A") && $iterateY < 8) {
            $iterateX--;
            $iterateY++;

            $diags[1][] = [
                "x" => chr($iterateX),
                "y" => $iterateY,
            ];
            $diags[1] = collect($diags[1] ?? [])->sortBy('y')->toArray();
        }

        $iterateX = ord($x);
        $iterateY = $y;
        while($iterateX > ord("A") && $iterateY > 1) {
            $iterateX--;
            $iterateY--;

            $diags[2][] = [
                "x" => chr($iterateX),
                "y" => $iterateY,
            ];
            $diags[2] = collect($diags[2] ?? [])->sortByDesc('y')->toArray();
        }

        $iterateX = ord($x);
        $iterateY = $y;
        while($iterateX < ord("H") && $iterateY > 1) {
            $iterateX++;
            $iterateY--;

            $diags[3][] = [
                "x" => chr($iterateX),
                "y" => $iterateY,
            ];
            $diags[3] = collect($diags[3] ?? [])->sortByDesc('y')->toArray();
        }

        return $diags;
    }
}
