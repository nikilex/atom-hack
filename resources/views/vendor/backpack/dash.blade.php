@extends(backpack_view('blank'))

@section('content')

@php
use Illuminate\Support\Carbon;


$dateNow = Carbon::now();

$datePlus = Carbon::now();
@endphp

<div class="row">
    <div class="col">
        <h2>Очередь производства</h2>
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
            <div class="col-6">
                <div class="row">
                    <div class="col-12">
                        <h3>В очереди</h3>
                    </div>
                    <div class="col">
                        <table class="table table-bordered">
                            <tr>
                                <th></th>
                                <th>Название серии</th>
                                <th>Планируемая дата производства</th>
                            </tr>

                            @foreach($queues as $key => $queue)
                            @php
                            $datePlus = $dateNow->addHours('18')
                            @endphp
                            <tr>
                                <td>
                                    @if($key > 0)
                                    <a href="{{ route('backpack.queue.change-priority', ['queue_id' => $queue->id, 'type' => 'up']) }}">&#8657</a>  
                                    @endif
                                    @if($key < $queues->count() - 1)
                                    <a href="{{ route('backpack.queue.change-priority', ['queue_id' => $queue->id, 'type' => 'down']) }}">&#8659</a>
                                    @endif
                                </td>
                                <td><a href="{{ route('backpack.queue.index', ['queue_id' => $queue->id]) }}">{{ $queue->number }}</a></td>
                                <td>{{ $datePlus->format('d.m.Y H:i:s') }}</td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="row">
                    <div class="col-12">
                        <h3>Готовые изделия</h3>
                    </div>
                    <div class="col">
                        <table class="table table-bordered">
                            <tr>
                                <th>Название серии</th>
                                <th>Время окончания производства</th>
                            </tr>
                            @php
                            $datePlus = $dateNow->subMonth(2)
                            @endphp
                            @foreach($queues as $queue)
                            @php
                            $datePlus = $dateNow->addHours('18')
                            @endphp
                            <tr>
                                <td>{{ $queue->number }}</td>
                                <td>{{ $datePlus->format('d.m.Y H:i:s') }}</td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection