@extends(backpack_view('blank'))

@section('content')

@php
use Illuminate\Support\Carbon;


$dateNow = Carbon::now();

$datePlus = Carbon::now()->startOfDay();

$intervals = [];

$index = 0;

while($datePlus < $dateNow->endOfDay()) { 
    $queueName = $equipment->name;
    if($equipment->queues->count()) {
        if($index < 3) {
            $queueName = $equipment->queues[0]->number;
        }

        if($index > 3 && $index < 6) {
            $queueName = $equipment->queues[1]->number;
        }

        if($index > 6 && $index < 9) {
            $queueName = $equipment->queues[2]->number;
        }
    }
    
    $intervals[$index]=[ 
        'name'=> $queueName,
        'temp_now' => $equipment->temp_now,
        'date_start' => $datePlus->format('d.m.Y H:i:s')
    ];

    $datePlus = $datePlus->addHours(rand(4,6));

    $intervals[$index]['date_end'] = $datePlus->format('d.m.Y H:i:s');


    $intervals[$index + 1] = [
        'name' => 'Прерывание',
        'temp_now' => $equipment->temp_now,
        'date_start' => $datePlus->format('d.m.Y H:i:s')
    ];

    $datePlus = $datePlus->addMinutes(rand(15,60));

    $intervals[$index + 1]['date_end'] = $datePlus->format('d.m.Y H:i:s');
    $index = $index + 2;
}



@endphp

    <div class="row mb-3">
        <div class="col">
            <h2>План работы агрегата <b>{{ $equipment->name }}</b></h2>
        </div>
        <div class="col-12">
            <h3>Дата: {{ $dateNow->format('d.m.Y') }}</h3>
        </div>
    </div>
    <div class="row">

    </div>
    <div class="row">
        <div class="col">
            <table class="table table-bordered">
                <tr>
                    <th>Название серии</th>
                    <th>Температура</th>
                    <th>Начало</th>
                    <th>Окончание</th>
                </tr>

                @foreach($intervals  as $interval) <tr>
                    <td>{{ $interval['name'] }}</td>
                    <td>{{ $interval['temp_now']}}</td>
                    <td>{{ $interval['date_start'] }}</td>
                    <td>{{ $interval['date_end'] }}</td>
                @endforeach

            </table>
        </div>
    </div>


    @endsection