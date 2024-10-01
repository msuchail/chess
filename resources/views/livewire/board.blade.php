<table class="rotate-180">
    <tbody>
    @foreach($board as $y=>$col)
        <tr class="rotate-180">
            @foreach($col as $x=>$color)
                <td class="w-20 h-20 border bg-{{ $color }}">
                    <span class="w-full h-full flex flex-col justify-center align-middle">
                        @if($positions[$x][$y])
                            <img wire:click.self="tryToEat('{{$x}}', {{$y}})" wire:click="askPossibilities('{{$x}}', {{$y}})" class="text-center" src="/images/{{ $positions[$x][$y] }}.png">
                        @elseif(collect($possibleMovement)->filter(fn($item) => $item['x'] === $x && $item['y'] === $y)->isNotEmpty())
                            <span wire:click="move('{{$x}}', {{$y}})" class="text-center text-gray-500 text-3xl">O</span>
                        @endif
                    </span>
                </td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>
