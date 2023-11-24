<?php

namespace App\Http\Controllers\Admin;

use App\Models\Equipment;
use App\Models\Queue;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Carbon;

/**
 * Class PlanWorkAgregateController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PlanWorkAgregateController extends Controller
{
    protected $data = [];

    public function index(Request $request)
    {
        $this->data['title'] = 'Дашбоард';

        $this->data['breadcrumbs'] = [
            'Главная' => backpack_url('dash'),
            'План работы агрегата' => false
        ];

        $this->data['equipment'] = Equipment::with('queues')->where('id', $request->equipment_id)->first();

        return view(backpack_view('plane_work_agregate'), $this->data);
    }

}
