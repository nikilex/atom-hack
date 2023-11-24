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
        CRUD::setEntityNameStrings('Технологическую карту', 'Технологические карты');
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
                'label' => 'Номер серии',
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
                'label' => "Номер серии",
                'type'  => 'text',
            ],
            [   // Text
                'name'  => 'priority',
                'label' => "Приоритет",
                'type'  => 'text',
               // 'options' => [1, 2, 3, 4, 5]
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
            [   // SelectMultiple = n-n relationship (with pivot table)
                'label'     => "Оборудование",
                'type'      => 'relationship',
                'name'      => 'equipment_id', // the method that defines the relationship in your Model
            
                // optional
                'entity'    => 'equipment', // the method that defines the relationship in your Model
                'model'     => "App\Models\Equipment", // foreign key model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'pivot'     => true, // on create&update, do you need to add/delete pivot table entries?
            
                // also optional
                // 'options'   => (function ($query) {
                //     return $query->orderBy('name', 'ASC')->where('depth', 1)->get();
                // })
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
            [   // Text
                'name'  => 'temp',
                'label' => "Температура",
                'type'  => 'text',
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
