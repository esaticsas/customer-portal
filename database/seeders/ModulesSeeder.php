<?php

namespace Database\Seeders;

use Esatic\ActiveUser\Models\Module;
use Illuminate\Database\Seeder;

class ModulesSeeder extends Seeder
{
    private array $modules = [
        [
            'name' => 'esat_Requisiciones',
            'label' => 'Requisiciones',
            'position' => 10,
            'icon' => 'mat_solid:checklist',
            'link' => '/esat-requisiciones',
            'type' => 'basic'
        ]
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->modules as $moduleItem) {
            /** @var Module $module */
            $module = Module::query()->where('name', '=', $moduleItem['name'])->firstOrNew($moduleItem);
            $module->save();
        }
    }
}
