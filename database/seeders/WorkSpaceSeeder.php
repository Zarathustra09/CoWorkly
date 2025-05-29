<?php

                namespace Database\Seeders;

                use App\Models\WorkSpace;
                use App\Models\WorkSpaceCategory;
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
                                'hourly_rate' => 600,
                                'daily_rate' => 3000,
                                'is_available' => true,
                                'image' => 'single-coworking-space.png',
                            ],
                            [
                                'name' => 'Study Pod',
                                'category_id' => $workspaceRates,
                                'type' => 'study_pod',
                                'description' => 'Semi-private booth for quiet study sessions',
                                'hourly_rate' => 100,
                                'daily_rate' => 500,
                                'is_available' => true,
                                'image' => 'single-coworking-capsule.png',
                            ],
                            [
                                'name' => 'Hot Desk',
                                'category_id' => $workspaceRates,
                                'type' => 'desk',
                                'description' => 'Flexible workspace available on a first-come basis',
                                'hourly_rate' => 80,
                                'daily_rate' => 400,
                                'is_available' => true,
                                'image' => 'single-coworking-cubicle.png',
                            ],
                            [
                                'name' => 'Meeting Room',
                                'category_id' => $workspaceRates,
                                'type' => 'meeting_room',
                                'description' => 'Professional meeting space with presentation equipment',
                                'hourly_rate' => 200,
                                'daily_rate' => 1000,
                                'is_available' => true,
                                'image' => 'coworking-group-space.png',
                            ],
                            [
                                'name' => 'Student Discount Plan',
                                'category_id' => $workspaceRates,
                                'type' => 'study_pod',
                                'description' => '15% off with valid ID on all rates, special monthly study pod plan',
                                'hourly_rate' => 85,
                                'daily_rate' => 425,
                                'is_available' => true,
                                'image' => 'coworking-group-space-capsule.png',
                            ],

                            // Membership Plans
                            [
                                'name' => 'Daily Plan',
                                'category_id' => $membershipPlans,
                                'type' => 'desk',
                                'description' => 'Includes 1-day hot desk, Wi-Fi, charging ports, free coffee/tea',
                                'daily_rate' => 200,
                                'is_available' => true,
                                'image' => 'single-coworking-space.png',
                            ],
                            [
                                'name' => 'Weekly Plan',
                                'category_id' => $membershipPlans,
                                'type' => 'desk',
                                'description' => 'Includes 5-day hot desk access, 3hrs meeting room for 1 week',
                                'daily_rate' => 800,
                                'is_available' => true,
                                'image' => 'single-coworking-space-b.png',
                            ],
                            [
                                'name' => 'Monthly Plan',
                                'category_id' => $membershipPlans,
                                'type' => 'desk',
                                'description' => 'Unlimited hot desk, 1 meeting room for 1 month, locker use',
                                'daily_rate' => 3000,
                                'is_available' => true,
                                'image' => 'single-coworking-space-b.png',
                            ],
                            [
                                'name' => 'Student Monthly',
                                'category_id' => $membershipPlans,
                                'type' => 'study_pod',
                                'description' => 'Unlimited study pod access, 1hr meeting room',
                                'daily_rate' => 2200,
                                'is_available' => true,
                                'image' => 'single-coworking-capsule.png',
                            ],
                            [
                                'name' => 'Flex Plan (10-days)',
                                'category_id' => $membershipPlans,
                                'type' => 'desk',
                                'description' => '10-day hot desk credits to use anytime',
                                'daily_rate' => 1500,
                                'is_available' => true,
                                'image' => 'single-coworking-cubicle.png',
                            ],

                            // Group Plans
                            [
                                'name' => 'Group Study Pack',
                                'category_id' => $groupPlans,
                                'type' => 'meeting_room',
                                'description' => 'Up to 5 students, 20hrs/week whiteboard, group specials',
                                'daily_rate' => 2400,
                                'is_available' => true,
                                'image' => 'coworking-group-space.png',
                            ],
                            [
                                'name' => 'Startup Team Pack',
                                'category_id' => $groupPlans,
                                'type' => 'meeting_room',
                                'description' => 'Up to 7 members, 5hrs/month meeting room, 3 lockers',
                                'daily_rate' => 7500,
                                'is_available' => true,
                                'image' => 'coworking-group-space-b.png',
                            ],
                        ];

                        foreach ($workspaces as $workspace) {
                            WorkSpace::create($workspace);
                        }
                    }
                }
