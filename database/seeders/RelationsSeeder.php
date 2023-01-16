<?php

namespace Database\Seeders;

use Esatic\Suitecrm\Models\RelatedModule;
use Illuminate\Database\Seeder;

class RelationsSeeder extends Seeder
{
    private array $items = [
        [
            'relation_name' => 'cases',
            'related_table' => 'accounts_cases',
            'primary_table' => 'cases',
            'related_field' => 'case_id',
            'filter_field' => 'account_id',
            'module' => 'Cases'
        ]
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->items as $item) {
            /** @var RelatedModule $related */
            $related = RelatedModule::query()->where('relation_name', '=', $item['relation_name'])->firstOrNew();
            $related->fill($item);
            $related->save();
        }
    }
}
