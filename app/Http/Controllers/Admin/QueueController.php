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

        $this->data['queue'] = Queue::with('operations', 'equipment')->where('id', $request->queue_id)->first();

        return view(backpack_view('queue'), $this->data);
    }

}
