<div>
    <livewire:board :positions="$positions" :key="json_encode($positions)" />
    <p>Turn : {{ $turn }}</p>
    <p>Chess : {{ $chess }}</p>
    <p>{{ json_encode($lastMoves) }}</p>
</div>
