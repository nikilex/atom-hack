<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\EquipmentRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class EquipmentCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class EquipmentCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Equipment::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/equipment');
        CRUD::setEntityNameStrings('Оборудование', 'Оборудование');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $langStatus = [
            'heating_of_parts' => 'Нагревание деталей',
            'temperature_change' => 'Изменение температуры',
            'under_maintenance' => 'На обслуживании',
            'crash' => 'Авария'
        ];

        $langOperations = [
            'prokat' => 'Прокат',
            'kovka' => 'Ковка',
            'otzhig' => 'Отжиг',
        ];

        CRUD::addColumns([
            [
                'name'  => 'name',
                'label' => 'Оборудование',
                'wrapper'   => [
                    'href'   => function ($crud, $column, $entry, $related_key) {
                        return backpack_url('equipment/' . $entry->id);
                    },
                ],
            ],
            [
                'name'  => 'status',
                'label' => 'Статус',
                'value' => function($entry) use ($langStatus) {
                    return $langStatus[$entry->status] ?? $entry->status;
                }
            ],
            [
                'name'  => 'operations',
                'label' => 'Операции',
                'value' => function($entry) use ($langOperations) {
                    return $langOperations[$entry->operations] ?? $entry->operations;
                }
            ],
            [
                'name'  => 'temp_now',
                'label' => 'Температура актуальная',
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
        CRUD::setValidation(EquipmentRequest::class);

        $this->crud->addFields([
            [   // Text
                'name'  => 'name',
                'label' => "Наименование",
                'type'  => 'text',
            ],
            [
                'name'  => 'status',
                'label' => 'Статус',
                'type'  => 'enum',
                // optional, specify the enum options with custom display values
                'options' => [
                    'heating_of_parts' => 'Нагревание деталей',
                    'temperature_change' => 'Изменение температуры',
                    'under_maintenance' => 'На обслуживании',
                    'crash' => 'Авария'
                ],
            ],
            [
                'name'  => 'operations',
                'label' => 'Операция',
                'type'  => 'enum',
                // optional, specify the enum options with custom display values
                'options' => [
                    'prokat' => 'Прокат',
                    'kovka' => 'Ковка',
                    'otzhig' => 'Отжиг',
                ]
            ],
            // [
            //     'name'  => 'temp_now',
            //     'label' => "Температура сейчас",
            //     'type'  => 'text',
            // ]
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
