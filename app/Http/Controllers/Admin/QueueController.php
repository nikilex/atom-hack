<?php

namespace App\Http\Controllers\Admin;

use App\Models\Equipment;
use App\Models\Queue;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Carbon;

/**
 * Class QueueController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class QueueController extends Controller
{
    protected $data = [];

    public function index(Request $request)
    {
        $this->data['title'] = 'Маршрутная карта';

        $this->data['breadcrumbs'] = [
            'Главная' => backpack_url('dash'),
            'Маршрутная карта' => false
        ];

        $queue = Queue::with('operationsHasMany', 'equipment')->where('id', $request->queue_id)->first();

        $this->data['queue'] = $queue;

        $overMap = rand(15, 180);

        $dateSub = Carbon::now()->endOfDay()->subMinutes($overMap);

        $operationsArr = [];

        $reverseOperations = $queue->operationsHasMany->reverse();

        foreach ($reverseOperations as $key => $reverseOperation) {
            $operationsArr[] = [
                'name' => $reverseOperation->name_queue,
                'dateEnd' => $dateSub->format('d.m.Y H:i:s'),
                'dateStart' => $dateSub->subMinutes($reverseOperation->time)->format('d.m.Y H:i:s'),
            ];

            if($key < $reverseOperations->count() - 2) {
                $dateSub = $dateSub->subMinutes($reverseOperation->time);
            }
        }

        $normOperations = array_reverse($operationsArr);

        $this->data['normOperations'] = $normOperations;

        return view(backpack_view('queue'), $this->data);
    }

    public function changePriority(Request $request)
    {
        $queue = Queue::find($request->queue_id);

        $queues = Queue::orderBy('priority')->get();

        $key = array_search($request->queue_id, $queues->pluck('id')->toArray());

        $beforeElements = $queues->slice(0, $key);
        $afterElements = $queues->slice($key + 1);

        foreach($queues as $queue) {
            $queue->update(['priority' => 1]);
        }

        foreach($beforeElements as $el) {
            $el->update(['priority' => 1]);
        }

        foreach($afterElements as $el) {
            $el->update(['priority' => 4]);
        }

        if ($request->type === 'up') {
            $queues[$key]->update(['priority' => 2]);
            $queues[$key - 1]->update(['priority' => 3]);
        }

        if ($request->type === 'down') {
            $queues[$key]->update(['priority' => 3]);
            $queues[$key + 1]->update(['priority' => 2]);
        }

        return redirect()->route('backpack.dash.index');

        // foreach ($queues as $key => $queue) {

        //     if ($request->type === 'up') {
        //         if ($queue->id == $request->queue_id) {
        //             foreach ($queues->splice($key - 1) as $spliceQueue) {
        //                 $spliceQueue->update(['priority' => 2]);
        //             }
        //             $queue->update(['priority' => 2]);

        //             if (isset($queues[$key - 1])) {
        //                 $queues[$key - 1]->update(['priority' => 3]);
        //             }

        //             foreach ($queues->splice($key + 1) as $spliceQueue) {
        //                 $spliceQueue->update(['priority' => 3]);
        //             }

        //             break;
        //         }
        //     }

        //     // $queue->update(['priority', 3]);
        // }
        // dd($queues->where('id', $request->queue_id));
        // dd($queues->pluck('id')->toArray());
        // $key = array_search($request->queue_id, $queues->pluck('id'));

        // $arrBefore = $queues->splice($key);

        // dd($arrBefore);



        // foreach($queues as $key => $queue) {
        //     // if($request->type === 'up') {
        //     //     $startPriority = 1;
        //     //     $queue->priority
        //     // }

        //     if ($key < array_search($queue, $queues)) {
        //         if($request->type === 'up') {

        //         }
        //     }

        //     if ($key == array_search($queue, $queues)) {
        //         if($request->type === 'up') {

        //         }
        //     }
        // }
    }
}
