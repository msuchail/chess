<?php

namespace App\Livewire;

use App\Bishop;
use App\Chess;
use App\Instanciate;
use App\King;
use App\Knight;
use App\Queen;
use App\Rock;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Pawn;
use function PHPUnit\Framework\isNull;


//TODO : Implementer le jeu multijoueurs
//TODO : Implémenter l'IA
class Game extends Component
{
    use Instanciate;
    use Chess;
    public $turn = 'white';
    public array $lastMoves = [];

    public string|null $chess = null ;

    #[On('ask-possibilities')]
    function returnPossibleMovement(string $x, int $y): void
    {
        $color = explode('-', $this->positions[$x][$y])[0];

        if($color === $this->turn) {
            $item = $this->getInstance($this->positions, $x, $y, $color, $this->lastMoves);

            $possibleMovement = $item->returnPossibleMovement();
            $possibleEat = $item->returnPossibleEat();
        } else {
            $possibleMovement = [];
            $possibleEat = [];
        }
        $this->dispatch('possible-movement', $possibleMovement);
        $this->dispatch('possible-eat', $possibleEat);
    }

    #[On('move')]
    public function move(array $actualSelection, array $newPosition)
    {
        $item = $this->positions[$actualSelection['x']][$actualSelection['y']];

        //prise en passant
        if($item === 'white-pawn' &&
            !isset($this->positions[$newPosition['x']][$newPosition['y']]) &&
            $actualSelection['x'] !== $newPosition['x']
        ) {
            $this->positions[$newPosition['x']][$newPosition['y']-1] = null;
        } else if($item === 'black-pawn' &&
            !isset($this->positions[$newPosition['x']][$newPosition['y']]) &&
            $actualSelection['x'] !== $newPosition['x']
        ) {
            $this->positions[$newPosition['x']][$newPosition['y']+1] = null;
        }


        $this->positions[$actualSelection['x']][$actualSelection['y']] = null;
        $this->positions[$newPosition['x']][$newPosition['y']] = $item;

        $this->lastMoves = collect($this->lastMoves)->flatten(1)->push([
            'item'=>$item,
            'from'=>$actualSelection,
            'to' => $newPosition
        ])->chunk(2)->toArray();

        $this->turn = $this->turn === "white" ? 'black' : 'white';

        if($this->isChess($this->positions, $this->lastMoves, $this->turn)) {
            $this->chess = $this->turn;
        } else {
            $this->chess = null;
        }

    }

    public array $positions = [
        "A" => [1=>"white-rock", 2=>"white-pawn", 3=>null, 4=>null, 5=>null, 6=>null, 7=>"black-pawn", 8=>"black-rock"],
        "B" => [1=>"white-knight", 2=>"white-pawn", 3=>null, 4=>null, 5=>null, 6=>null, 7=>"black-pawn", 8=>"black-knight"],
        "C" => [1=>"white-bishop", 2=>"white-pawn", 3=>null, 4=>null, 5=>null, 6=>null, 7=>"black-pawn", 8=>"black-bishop"],
        "D" => [1=>"white-king", 2=>"white-pawn", 3=>null, 4=>null, 5=>null, 6=>null, 7=>"black-pawn", 8=>"black-king"],
        "E" => [1=>"white-queen", 2=>"white-pawn", 3=>null, 4=>null, 5=>null, 6=>null, 7=>"black-pawn", 8=>"black-queen"],
        "F" => [1=>"white-bishop", 2=>"white-pawn", 3=>null, 4=>null, 5=>null, 6=>null, 7=>"black-pawn", 8=>"black-bishop"],
        "G" => [1=>"white-knight", 2=>"white-pawn", 3=>null, 4=>null, 5=>null, 6=>null, 7=>"black-pawn", 8=>"black-knight"],
        "H" => [1=>"white-rock", 2=>"white-pawn", 3=>null, 4=>null, 5=>null, 6=>null, 7=>"black-pawn", 8=>"black-rock"],
    ];


    public function render()
    {
        return view('livewire.game');
    }
}
