@extends(backpack_view('blank'))

@section('content')

@php
use Illuminate\Support\Carbon;

$overMap = rand(15, 180);
$dateNow = Carbon::now()->endOfDay()->subMinutes($overMap);

$dateSub = Carbon::now()->endOfDay()->subMinutes($overMap);
@endphp

<div class="row mb-3">
    <div class="col">
        <h2>Маршрутная карта для серии <b>{{ $queue->number }}</b></h2>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col">
                <table class="table table-bordered">
                    <tr>
                        <th>Название агрегата</th>
                        <th>Время начала операции</th>
                        <th>Время окончания операции</th>
                    </tr>

                    @foreach($queue->operations as $key => $operation)
                        <tr>
                            <td>{{ $queue->equipment->name }} - {{ $operation->name }}</td>
                            <td>{{ $dateSub->format('d.m.Y H:i:s') }}</td>
                            <td>{{ $dateSub->subMinutes($operation->pivot->time)->format('d.m.Y H:i:s') }}</td>
                        </tr>
                        @php
                        if($key < $queue->operations->count() - 2) {
                            $dateSub = $dateSub->subMinutes($operation->pivot->time);
                        }
                        @endphp
                    @endforeach
                </table>

                @if($queue->operations->isEmpty())
                <div class="row">
                    <div class="col">
                        <h3 class="text-center">Пусто</h3>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>


@endsection