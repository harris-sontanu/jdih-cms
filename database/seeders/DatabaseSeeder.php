<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            SettingSeeder::class,
            TypeSeeder::class,
            CategorySeeder::class,
            InstituteSeeder::class,
            MatterSeeder::class,
            FieldSeeder::class,
            LegislationSeeder::class,
            LegislationMatterSeeder::class,
            LegislationRelationshipSeeder::class,
            TaxonomySeeder::class,
            EmployeeSeeder::class,
            EmployeeTaxonomySeeder::class,
            PostSeeder::class,
            QuestionSeeder::class,
            AnswerSeeder::class,
            VoteSeeder::class,
            LegislationDocumentSeeder::class,
            LegislationDownloadLogSeeder::class,
            LegislationLogSeeder::class,
            LinkSeeder::class,
            SlideSeeder::class,
        ]);
    }
}
