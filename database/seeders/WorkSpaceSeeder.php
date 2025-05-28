<?php

namespace Database\Seeders;

use App\Models\WorkSpace;
use App\Models\WorkSpaceCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WorkSpaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get category IDs for reference
        $workspaceRates = WorkSpaceCategory::where('name', 'Workspace Rates')->first()->id;
        $membershipPlans = WorkSpaceCategory::where('name', 'Membership Plans')->first()->id;
        $groupPlans = WorkSpaceCategory::where('name', 'Group Plans')->first()->id;

        $workspaces = [
            // Workspace Rates
            [
                'name' => 'Private Desk',
                'category_id' => $workspaceRates,
                'type' => 'desk',
                'description' => 'Private dedicated workspace for individual focused work',
                'capacity' => 1,
                'location' => 'Various locations',
                'amenities' => json_encode(['wifi', 'power outlets', 'desk lamp', 'ergonomic chair']),
                'hourly_rate' => 600,
                'daily_rate' => 3000,
                'is_available' => true,
                'is_premium' => true,
                'images' => json_encode(['single-coworking-space.png', 'single-coworking-space-b.png', 'single-coworking-space-c.png']),
                'equipment' => json_encode(['ergonomic chair', 'large desk', 'desk lamp']),
            ],
            [
                'name' => 'Study Pod',
                'category_id' => $workspaceRates,
                'type' => 'study_pod',
                'description' => 'Semi-private booth for quiet study sessions',
                'capacity' => 1,
                'location' => 'Library Zone',
                'amenities' => json_encode(['wifi', 'power outlets', 'noise reduction']),
                'hourly_rate' => 100,
                'daily_rate' => 500,
                'is_available' => true,
                'is_premium' => false,
                'images' => json_encode(['single-coworking-capsule.png', 'single-coworking-capsule-b.png', 'single-coworking-capsule-c.png']),
                'equipment' => json_encode(['desk lamp', 'standard chair']),
            ],
            [
                'name' => 'Hot Desk',
                'category_id' => $workspaceRates,
                'type' => 'desk',
                'description' => 'Flexible workspace available on a first-come basis',
                'capacity' => 1,
                'location' => 'Open Work Area',
                'amenities' => json_encode(['wifi', 'power outlets', 'community atmosphere']),
                'hourly_rate' => 80,
                'daily_rate' => 400,
                'is_available' => true,
                'is_premium' => false,
                'images' => json_encode(['single-coworking-cubicle.png', 'single-coworking-space-c.png']),
                'equipment' => json_encode(['standard chair', 'shared table space']),
            ],
            [
                'name' => 'Meeting Room',
                'category_id' => $workspaceRates,
                'type' => 'meeting_room',
                'description' => 'Professional meeting space with presentation equipment',
                'capacity' => 8,
                'location' => 'Conference Wing',
                'amenities' => json_encode(['wifi', 'projector', 'whiteboard', 'video conferencing']),
                'hourly_rate' => 200,
                'daily_rate' => 1000,
                'is_available' => true,
                'is_premium' => true,
                'images' => json_encode(['coworking-group-space.png', 'coworking-group-space-b.png', 'coworking-group-space-c.png']),
                'equipment' => json_encode(['conference table', 'chairs', 'projector', 'whiteboard']),
            ],
            [
                'name' => 'Student Discount Plan',
                'category_id' => $workspaceRates,
                'type' => 'study_pod',
                'description' => '15% off with valid ID on all rates, special monthly study pod plan',
                'capacity' => 1,
                'location' => 'Student Zone',
                'amenities' => json_encode(['wifi', 'power outlets', 'quiet environment']),
                'hourly_rate' => 85,
                'daily_rate' => 425,
                'is_available' => true,
                'is_premium' => false,
                'images' => json_encode(['coworking-group-space-capsule.png', 'single-coworking-capsule-b.png']),
                'equipment' => json_encode(['desk', 'chair', 'desk lamp']),
            ],

            // Membership Plans
            [
                'name' => 'Daily Plan',
                'category_id' => $membershipPlans,
                'type' => 'desk',
                'description' => 'Includes 1-day hot desk, Wi-Fi, charging ports, free coffee/tea',
                'capacity' => 1,
                'location' => 'Open Work Area',
                'amenities' => json_encode(['wifi', 'charging ports', 'free coffee/tea']),
                'daily_rate' => 200,
                'is_available' => true,
                'is_premium' => false,
                'images' => json_encode(['single-coworking-space.png']),
                'equipment' => json_encode(['standard chair', 'shared desk space']),
            ],
            [
                'name' => 'Weekly Plan',
                'category_id' => $membershipPlans,
                'type' => 'desk',
                'description' => 'Includes 5-day hot desk access, 3hrs meeting room for 1 week',
                'capacity' => 1,
                'location' => 'Open Work Area + Meeting Rooms',
                'amenities' => json_encode(['wifi', 'charging ports', 'meeting room access']),
                'daily_rate' => 800,
                'is_available' => true,
                'is_premium' => false,
                'images' => json_encode(['single-coworking-space-b.png']),
                'equipment' => json_encode(['standard chair', 'shared desk space', 'meeting room equipment']),
            ],
            [
                'name' => 'Monthly Plan',
                'category_id' => $membershipPlans,
                'type' => 'desk',
                'description' => 'Unlimited hot desk, 1 meeting room for 1 month, locker use',
                'capacity' => 1,
                'location' => 'Full Access',
                'amenities' => json_encode(['wifi', 'charging ports', 'locker use', 'meeting room access']),
                'daily_rate' => 3000,
                'is_available' => true,
                'is_premium' => true,
                'images' => json_encode(['single-coworking-space-c.png', 'coworking-group-space-d.png']),
                'equipment' => json_encode(['standard chair', 'shared desk space', 'locker', 'meeting room equipment']),
            ],
            [
                'name' => 'Student Monthly',
                'category_id' => $membershipPlans,
                'type' => 'study_pod',
                'description' => 'Unlimited study pod access, 1hr meeting room',
                'capacity' => 1,
                'location' => 'Student Zone',
                'amenities' => json_encode(['wifi', 'charging ports', 'quiet environment', 'limited meeting room access']),
                'daily_rate' => 2200,
                'is_available' => true,
                'is_premium' => false,
                'images' => json_encode(['single-coworking-capsule.png']),
                'equipment' => json_encode(['desk', 'chair', 'desk lamp']),
            ],
            [
                'name' => 'Flex Plan (10-days)',
                'category_id' => $membershipPlans,
                'type' => 'desk',
                'description' => '10-day hot desk credits to use anytime',
                'capacity' => 1,
                'location' => 'Open Work Area',
                'amenities' => json_encode(['wifi', 'charging ports', 'flexible usage']),
                'daily_rate' => 1500,
                'is_available' => true,
                'is_premium' => false,
                'images' => json_encode(['single-coworking-cubicle.png']),
                'equipment' => json_encode(['standard chair', 'shared desk space']),
            ],

            // Group Plans
            [
                'name' => 'Group Study Pack',
                'category_id' => $groupPlans,
                'type' => 'meeting_room',
                'description' => 'Up to 5 students, 20hrs/week whiteboard, group specials',
                'capacity' => 5,
                'location' => 'Study Group Areas',
                'amenities' => json_encode(['wifi', 'whiteboard', 'group seating']),
                'daily_rate' => 2400,
                'is_available' => true,
                'is_premium' => false,
                'images' => json_encode(['coworking-group-space.png', 'coworking-group-space-capsule.png']),
                'equipment' => json_encode(['large table', 'chairs', 'whiteboard', 'markers']),
            ],
            [
                'name' => 'Startup Team Pack',
                'category_id' => $groupPlans,
                'type' => 'meeting_room',
                'description' => 'Up to 7 members, 5hrs/month meeting room, 3 lockers',
                'capacity' => 7,
                'location' => 'Team Areas',
                'amenities' => json_encode(['wifi', 'meeting room access', 'lockers']),
                'daily_rate' => 7500,
                'is_available' => true,
                'is_premium' => true,
                'images' => json_encode(['coworking-group-space-b.png', 'coworking-group-space-c.png', 'coworking-group-space-d.png']),
                'equipment' => json_encode(['conference table', 'chairs', 'whiteboards', '3 lockers']),
            ],
        ];

        foreach ($workspaces as $workspace) {
            WorkSpace::create($workspace);
        }
    }
}
