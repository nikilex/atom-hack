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

        $this->data['queues'] = Queue::with('equipment', 'operations')->orderBy('priority')->get();

        return view(backpack_view('dash'), $this->data);
    }

    public function work()
    {
        $this->data['title'] = 'Дашбоард';

        $this->data['breadcrumbs'] = [
            'Главная' => backpack_url('dash'),
        ];

        $this->data['queues'] = Queue::with('equipment', 'operations')->orderBy('priority')->get();
        $datePlus = Carbon::now()->startOfDay();
        $this->data['arr'] = [
            [
                'time' => '25.11.2023 00:00:00',
                'name' => '34-15053-18 №17,19',
                'ag1'  => 'Печь 2',
                'ag2' => 'Прокат'
            ],
            [
                'time' => '25.11.2023 00:15:00',
                'name' => '34-15053-18 №17,19',
                'ag1'  => 'Прокат',
                'ag2' => 'Печь 2'
            ],
            [
                'time' => '25.11.2023 01:45:00',
                'name' => '34-15053-18 №17,19',
                'ag1'  => 'Печь 2',
                'ag2' => 'Прокат'
            ],
            [
                'time' => '25.11.2023 02:00:00',
                'name' => '34-15093-18 №1,2',
                'ag1'  => 'Печь 5',
                'ag2' => 'Ковка'
            ],
            [
                'time' => '25.11.2023 02:15:00',
                'name' => '34-15093-18 №1,2',
                'ag1'  => 'Ковка',
                'ag2' => 'Печь 5'
            ],
            [
                'time' => '25.11.2023 03:45:00',
                'name' => '34-15093-18 №1,2',
                'ag1'  => 'Печь 5',
                'ag2' => 'Ковка'
            ],
            [
                'time' => '25.11.2023 04:00:00',
                'name' => '34-15093-18 №1,2',
                'ag1'  => 'Ковка',
                'ag2' => 'Печь 5'
            ],
            [
                'time' => '25.11.2023 04:30:00',
                'name' => '2383-18 часть 1',
                'ag1'  => 'Печь 6',
                'ag2' => 'Прокат'
            ],
            [
                'time' => '25.11.2023 04:45:00',
                'name' => '2383-18 часть 1',
                'ag1'  => 'Прокат',
                'ag2' => 'Печь 6'
            ],
            [
                'time' => '25.11.2023 06:15:00',
                'name' => '2383-18 часть 1',
                'ag1'  => 'Печь 6',
                'ag2' => 'Ковка'
            ],

        ];

        return view(backpack_view('work'), $this->data);
    }

}
