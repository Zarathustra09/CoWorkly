<?php

namespace Database\Seeders;

use App\Models\WorkSpaceCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WorkSpaceCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Workspace Rates',
                'description' => 'Per person, valid for 3 months within purchase',
                'icon' => 'workspace-icon.png',
            ],
            [
                'name' => 'Membership Plans',
                'description' => 'All valid for 6 months within purchase',
                'icon' => 'membership-icon.png',
            ],
            [
                'name' => 'Group Plans',
                'description' => 'Valid for 3 months within purchase',
                'icon' => 'group-icon.png',
            ],
        ];

        foreach ($categories as $category) {
            WorkSpaceCategory::create($category);
        }
    }
}
