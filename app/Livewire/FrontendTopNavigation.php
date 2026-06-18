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
    #[On('loggedOut')]
    public function refresh(): void
    {
        $this->navigation = $this->buildNavigation();
    }

    public function mount()
    {
        $this->navigation = $this->buildNavigation();
    }

    private function buildNavigation()
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
            "label" => 'Privatunterricht',
            "link" => route('frontend.private.lessons'),
            'position' => 4,
        ];

        $categories[] = [
            "label" => "Kursübersicht",
            "link" => route('frontend.course.info'),
            'position' => count($categories) + 1,
        ];

        $categories[] =
            [
                "label" => 'Mitgliedschaft',
                "link" => route('frontend.memebrship.create'),
                'position' => 4,
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
                "label" => 'Events & Partys',
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
                    [
                        "label" => 'CrashKurse',
                        "link" => route('frontend.crashcourse.list'),
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
                "label" => 'Tanzreisen',
                "link" => url('https://salsatanzreise.de'),
                'position' => 4,
            ],

            [
                "label" => 'Team',
                "link" => route('frontend.team'),
                'position' => 6,
            ],
            [
                "label" => 'Gutscheine',
                "link" => route('frontend.coupon', 'gutsheine'),
                'position' => 7,
            ],
            [
                "label" => 'Kontakt',
                "link" => route('frontend.kontakt'),
                'position' => 8,
            ],
            [
                "label" => 'Mein Konto',
                "submenu" => Auth::guard('customer')->check() ? $this->getAuthenticatedUserMenu() : $this->getGuestUserMenu(),
                'position' => 9,
            ],
        ])->sortBy('position');
    }

    private function getAuthenticatedUserMenu()
    {
        return [
            [
                "label" => 'Mein Konto',
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
