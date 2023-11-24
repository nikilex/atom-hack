<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\QueueRequest;
use App\Models\OperationQueue;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class QueueCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class QueueCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Queue::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/queue');
        CRUD::setEntityNameStrings('Серию', 'Серии');

        CRUD::addSaveAction([
            'name' => 'save_action_one',
            'redirect' => function ($crud, $request, $itemId) {
                return route('backpack.dash.index');
            }, // what's the redirect URL, where the user will be taken after saving?

            // OPTIONAL:
            'button_text' => 'Сохранить', // override text appearing on the button
            // You can also provide translatable texts, for example:
            // 'button_text' => trans('backpack::crud.save_action_one'),
            'visible' => function ($crud) {
                return true;
            }, // customize when this save action is visible for the current operation
            'referrer_url' => function ($crud, $request, $itemId) {
                return route('backpack.dash.index');
            }, // override http_referrer_url
            'order' => 1, // change the order save actions are in
        ]);
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::addColumns([
            [
                'name'  => 'priority',
                'label' => 'Приоритет',
            ],
            [
                'name'  => 'number',
                'label' => 'Наименование серии',
            ],
            [
                'name'  => 'count_in_sadok',
                'label' => 'Кол-во в садке',
            ],
            [
                'name'  => 'boyki',
                'label' => 'Кол-во боек',
            ],
            [
                'name'  => 'equipment_id',
                'label' => 'Оборудование',
                'type'  => 'relationship',
            ],
            [
                'name'  => 'temp',
                'label' => 'Температура',
            ],
        ]);
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(QueueRequest::class);

        $this->crud->addFields([
            [   // Text
                'name'  => 'number',
                'label' => "Наименование серии",
                'type'  => 'text',
            ],
            [   // Text
                'name'  => 'priority',
                'label' => "Приоритет",
                'type'  => 'select_from_array',
                'options'     => ['1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5'],
                'allows_null' => false,
                'default'     => '1',
            ],
            [   // Text
                'name'  => 'count_in_sadok',
                'label' => "Кол-во в садке",
                'type'  => 'enum',
                'options' => [
                    '1' => 1,
                    '2' => 2
                ]
            ],
            [   // Text
                'name'  => 'boyki',
                'label' => "Кол-во боек",
                'type'  => 'enum',
                'options' => [
                    '1' => 1,
                    '2' => 2,
                    '3' => 3
                ]
            ],
            // [   // SelectMultiple = n-n relationship (with pivot table)
            //     'label'     => "Оборудование",
            //     'type'      => 'relationship',
            //     'name'      => 'equipment_id', // the method that defines the relationship in your Model

            //     // optional
            //     'entity'    => 'equipment', // the method that defines the relationship in your Model
            //     'model'     => "App\Models\Equipment", // foreign key model
            //     'attribute' => 'name', // foreign key attribute that is shown to user
            //     'pivot'     => true, // on create&update, do you need to add/delete pivot table entries?

            //     // also optional
            //     // 'options'   => (function ($query) {
            //     //     return $query->orderBy('name', 'ASC')->where('depth', 1)->get();
            //     // })
            // ],
            [   // Text
                'name'  => 'temp',
                'label' => "Температура",
                'type'  => 'text',
            ],
            [   
                // SelectMultiple = n-n relationship (with pivot table)
                'label'     => "Список операций",
                'type'      => 'relationship',
                'name'      => 'operationsHasMany', // the method that defines the relationship in your Model

                // // optional
                'entity'    => 'operationsHasMany', // the method that defines the relationship in your Model
                'model'     => OperationQueue::class, // foreign key model
                // 'attribute' => 'name', // foreign key attribute that is shown to user
                'pivot'     => true, // on create&update, do you need to add/delete pivot table entries?

                'subfields'   => [
                    [
                        'name' => 'name_queue',
                        'label' => 'Наименование операции',
                        'type' => 'select_from_array',
                        'options' => [
                            'Прокат' => 'Прокат',
                            'Ковка' => 'Ковка',
                            'Нагрев' => 'Нагрев',
                        ],
                        'allows_null' => false,
                        'default' => 'Нагрев'
                    ],
                    [
                        'name' => 'time',
                        'label' => 'Продолжительность',
                        'type' => 'text',
                    ],
                ],

                'pivotSelect'=> [
                    'label' => 'sd',
                    'attribute' => "name", // attribute on model that is shown to user
                    'placeholder' => 'Pick a company',
                    'wrapper' => [
                        'class' => 'col-md-6',
                    ],
                    // by default we call a $model->all(). you can configure it like in any other select
                    'options' => function($model) {
                        return $model;
                    },
                    // note that just like any other select, enabling ajax will require you to provide an url for the field
                    // to fetch available options. You can use the FetchOperation or manually create the enpoint.
                    //'ajax' => true,
                    //'data_source' => backpack_url('fetch'),
                ],
            ],
        ]);

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
