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

                   @foreach($arr as $item)
                    <tr>
                        <td>{{$item['time']}}</td>
                        <td>{{$item['name']}}</td>
                        <td>{{$item['ag1']}}</td>
                        <td>{{$item['ag2']}}</td>
</td>
                   @endforeach
                </table>
            </div>
        </div>
    </div>
</div>


@endsection