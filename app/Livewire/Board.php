<?php

namespace App\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class Board extends Component
{
    const COLOR1 = "white";
    const COLOR2 = "green-500";
    public array $board;
    public array $positions;
    public array $possibleMovement = [];
    public array $possibleEat = [];
    public array $actualSelection;

    public function askPossibilities(string $x, int $y): void
    {
        $this->actualSelection = ['x' => $x, 'y' => $y];
        $this->dispatch('ask-possibilities', $x, $y);
    }
    #[On('possible-movement')]
    public function possibleMovement(array $possibleMovement): void
    {
        $this->possibleMovement = $possibleMovement;
    }
    #[On('possible-eat')]
    public function possibleEat(array $possibleEat): void
    {
        $this->possibleEat = $possibleEat;
    }

    public function move(string $x, int $y): void
    {
        $this->dispatch('move',
            $this->actualSelection,
            [
                'x' => $x,
                'y' => $y
            ]
        );
        $this->resetPossibilities();
    }

    public function tryToEat(string $x, int $y): void
    {
        if (collect($this->possibleEat)->contains(['x' => $x, 'y'=>$y])) {
            $this->dispatch('move',
                $this->actualSelection,
                [
                    'x' => $x,
                    'y' => $y
                ]
            );
            $this->resetPossibilities();
        };
    }

    public function render(): View
    {
        return view('livewire.board');
    }


    public function boot() {
        for ($i = 1; $i <= 8; $i++) {
            $this->board[$i] =
                [
                    "A" => $this->getCaseColor("A", $i),
                    "B" => $this->getCaseColor("B", $i),
                    "C" => $this->getCaseColor("C", $i),
                    "D" => $this->getCaseColor("D", $i),
                    "E" => $this->getCaseColor("E", $i),
                    "F" => $this->getCaseColor("F", $i),
                    "G" => $this->getCaseColor("G", $i),
                    "H" => $this->getCaseColor("H", $i),
                ];
        }
    }

    private function getCaseColor(string $x, int $y):string
    {
        if(in_array($x, ["A", "C", "E", "G"])) {
            if($y%2 === 0){
                return self::COLOR1;
            } else {
                return self::COLOR2;
            }
        } else {
            if($y%2 === 0){
                return self::COLOR2;
            } else {
                return self::COLOR1;
            }
        }
    }

    private function resetPossibilities()
    {
        $this->possibleMovement = [];
        $this->possibleEat = [];
    }
}
