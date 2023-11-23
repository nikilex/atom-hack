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
        CRUD::column('name');
        CRUD::column('status');
        CRUD::column('operations');
        CRUD::column('temp_now');
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
                    'heating' => 'Нагревание',
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
            [
                'name'  => 'temp_now',
                'label' => "Температура сейчас",
                'type'  => 'text',
            ]
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
