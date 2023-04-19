<?php

namespace Database\Seeders;

use App\Enums\TaxonomyType;
use App\Models\Employee;
use App\Models\Taxonomy;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeTaxonomySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employees = Employee::all();
        foreach ($employees as $employee) {
            $sync = [];
            for ($i=0; $i < rand(1, 3); $i++) { 
                $taxonomy = Taxonomy::where('type', TaxonomyType::EMPLOYEE->name)->get()->random();
                $sync[] = $taxonomy->id;
            }
            $employee->taxonomies()->sync($sync);
        }
    }
}
