@extends(backpack_view('blank'))

@section('content')

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

                    @foreach($normOperations as $key => $operation)
                        <tr>
                            <td>{{ $queue->equipment->name }} - {{ $operation['name'] }}</td>
                            <td>{{ $operation['dateStart'] }}</td>
                            <td>{{ $operation['dateEnd'] }}</td>
                        </tr>
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