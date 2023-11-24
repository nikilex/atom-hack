<?php

namespace App\Http\Controllers\Admin;

use App\Models\Queue;
use Illuminate\Routing\Controller;
use Illuminate\Support\Carbon;

/**
 * Class OperationCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class DashController extends Controller
{
    protected $data = [];

    public function index()
    {
        $this->data['title'] = 'Дашбоард';

        $this->data['breadcrumbs'] = [
            'Главная' => backpack_url('dash'),
        ];

        $this->data['queues'] = Queue::with('equipment', 'operations')->get();

        return view(backpack_view('dash'), $this->data);
    }

}
