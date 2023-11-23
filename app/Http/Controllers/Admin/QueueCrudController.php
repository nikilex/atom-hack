<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\QueueRequest;
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
        CRUD::setEntityNameStrings('queue', 'queues');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('priority');
        CRUD::column('number');
        CRUD::column('count_in_sadok');
        CRUD::column('boyki');
        CRUD::column('temp');
        CRUD::column('created_at');
        CRUD::column('updated_at');

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
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
                'name'  => 'priority',
                'label' => "Приоритет",
                'type'  => 'text',
            ],
            [   // SelectMultiple = n-n relationship (with pivot table)
                'label'     => "Оборудование",
                'type'      => 'relationship',
                'name'      => 'equipments', // the method that defines the relationship in your Model
            
                // optional
                'entity'    => 'equipments', // the method that defines the relationship in your Model
                'model'     => "App\Models\Equipment", // foreign key model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'pivot'     => true, // on create&update, do you need to add/delete pivot table entries?
            
                // also optional
                // 'options'   => (function ($query) {
                //     return $query->orderBy('name', 'ASC')->where('depth', 1)->get();
                // })
            ],
            [   // Text
                'name'  => 'number',
                'label' => "Номер заготовки",
                'type'  => 'text',
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
                'label' => "Бойки",
                'type'  => 'enum',
                'options' => [
                    '1' => 1,
                    '2' => 2,
                    '3' => 3
                ]
            ],
            [   // Text
                'name'  => 'temp',
                'label' => "Температура",
                'type'  => 'text',
            ],
            [   // SelectMultiple = n-n relationship (with pivot table)
                'label'     => "Список операций",
                'type'      => 'relationship',
                'name'      => 'operations', // the method that defines the relationship in your Model
            
                // optional
                'entity'    => 'operations', // the method that defines the relationship in your Model
                'model'     => "App\Models\Operation", // foreign key model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'pivot'     => true, // on create&update, do you need to add/delete pivot table entries?
            
                // also optional
                // 'options'   => (function ($query) {
                //     return $query->orderBy('name', 'ASC')->where('depth', 1)->get();
                // })
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
