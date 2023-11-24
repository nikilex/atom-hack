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
        <a href="https://hk.test/admin/queue/create" class="btn btn-primary" data-style="zoom-in">
            <span class="ladda-label"><i class="la la-plus"></i> Добавить серию</span>
        </a>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <div class="row">
            <div class="col-12">
                <h3>В очереди</h3>
            </div>
            <div class="col">
                <table class="table table-bordered">
                    <tr>
                        <th>Название серии</th>
                        <th>Планируемая дата производства</th>
                    </tr>

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


@endsection