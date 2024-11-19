<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use App\Models\CourseCategory;
use Livewire\Component;
use Livewire\Attributes\On;

class FrontendTopNavigation extends Component
{
    public $navigation;

    #[On('loggedIn')]
    public function refresh()
    {
        $this->navigation = $this->buildNavidation();
    }

    public function mount()
    {
        $this->navigation = $this->buildNavidation();
    }

    private function buildNavidation()
    {
        $categories = CourseCategory::where('status', true)
            ->get()
            ->map(function ($category) {
                return [
                    "label" => $category->name,
                    "link" => route('frontend.course.category', $category->slug),
                    'position' => $category->id,
                ];
            })->sortBy('position')
            ->values()
            ->toArray();


        $categories[] =  [
            "label" => 'Betribsferien',
            "link" => route('frontend.vacation'),
            'position' => 4,
        ];
        $categories[] =  [
            "label" => 'Privatunterricht',
            "link" => route('frontend.private.lessons'),
            'position' => 4,
        ];

        $categories[] = [
            "label" => "Kursübersicht",
            "link" => route('frontend.course.info'),
            'position' => count($categories) + 1,
        ];




        return collect([
            [
                "label" => 'Home',
                'link' => route('frontend.home'),
                'position' => 1,
            ],
            [
                "label" => 'Kurse',
                "submenu" => collect($categories),
                'position' => 2,
            ],
            [
                "label" => 'Mitgliedschaft',
                "link" => route('frontend.memebrship.create'),
                'position' => 4,
            ],
            [
                "label" => 'Events',
                "submenu" => [
                    [
                        "label" => 'Party',
                        "link" => route('frontend.event.list'),
                        'position' => 3,
                    ],
                    [
                        "label" => 'Workshops',
                        "link" => route('frontend.workshops.list'),
                        'position' => 4,
                    ],
                    // [
                    //     "label" => 'Club events',
                    //     "link" => route('frontend.workshops.list'),
                    //     'position' => 4,
                    // ],
                    // [
                    //     "label" => 'Kalendar',
                    //     "link" => route('frontend.workshops.list'),
                    //     'position' => 4,
                    // ],
                ],
                'position' => 3,
            ],

            [
                "label" => 'Team',
                "link" => route('frontend.team'),
                'position' => 6,
            ],
            [
                "label" => 'Services',
                "submenu" => [
                    [
                        "label" => 'Preise',
                        "link" => route('frontend.preise'),
                        'position' => 1,
                    ],
                    [
                        "label" => 'Gutscheine',
                        "link" => route('frontend.coupon', 'gutsheine'),
                        'position' => 3,
                    ],
                ],
                'position' => 7,
            ],
            [
                "label" => 'Tanzreisen',
                "link" => url('https://salsatanzreise.de'),
                'position' => 7,
            ],
            [
                "label" => 'Mein Konto',
                "submenu" => Auth::guard('customer')->check() ? $this->getAuthenticatedUserMenu() : $this->getGuestUserMenu(),
                'position' => 8,
            ],
        ])->sortBy('position');
    }

    private function getAuthenticatedUserMenu()
    {
        return [
            [
                "label" => 'Mein konto',
                "link" => route('frontend.konto'),
                'position' => 1,
            ],
            [
                "label" => 'Logout',
                "form" => true,
                "action" => route('frontend.logout'),
                'position' => 2,
            ],
        ];
    }

    private function getGuestUserMenu()
    {
        return [
            [
                "label" => 'Einloggen',
                "link" => route('frontend.login'),
                'position' => 1,
            ],
            [
                "label" => 'Konto Erstellen',
                "link" => route('frontend.register'),
                'position' => 2,
            ],
        ];
    }
}
