@extends(backpack_view('blank'))

@section('content')

@php
use Illuminate\Support\Carbon;


$dateNow = Carbon::now();

$datePlus = Carbon::now();
@endphp

<div class="row">
    <div class="col">
        <h2>План участка работ</h2>
    </div>
</div>
<div class="row mb-3">
    <div class="col">
        <a href="{{ route('queue.create') }}" class="btn btn-primary" data-style="zoom-in">
            <span class="ladda-label"><i class="la la-plus"></i> Добавить серию</span>
        </a>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col">
                <table class="table table-bordered">
                    <tr>
                        <th></th>
                        <th>Название серии</th>
                        <th>Агрегат 1</th>
                        <th>Агрегат 2</th>
                    </tr>

                    @foreach($queues as $key => $queue)
                    @php
                    $datePlus = $dateNow->addHours(rand(1, 2))
                    @endphp
                    <tr>
                        <td>
                            {{ $datePlus->format('d.m.Y H:i:s') }}
                        </td>
                        <td>{{ $queue->number }}</td>
                        @if($key > 0 && stripos($queues[$key - 1]->equipment->name, 'печь') )
                        @php
                        $oborud = ['ковка', 'прокат'];
                        @endphp
                        <td>{{ $oborud[rand(0,1)] }}</td>
                        @else
                        <td>{{ $queue->equipment->name }}</td>
                        @endif

                        @if(($key > 0 && stripos($queues[$key - 1]->equipment->name,'ковка')) || ($key > 0 && stripos($queues[$key - 1]->equipment->name, 'прокат')))
                        <td>Печь {{ $key }}</td>
                       
                        @else
                        @php
                        $oborud = ['ковка', 'прокат'];
                        @endphp
                        <td>{{ $oborud[rand(0,1)] }}</td>
                        @endif
                        <!-- <td>{{ $queue->equipment->name }}</td> -->
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>


@endsection