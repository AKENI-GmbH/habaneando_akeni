<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Footer extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $navifation = [
            [
                "label" => "Über Uns",
                "menu" => [
                    [
                        "label" => "Team",
                        "link" => route('frontend.team'),
                    ],
                ],
            ],
            [
                "label" => "Habaneando",
                "menu" => [
                    [
                        "label" => "Betriebsferien",
                        "link" => route('frontend.vacation', 'betriebsferien'),
                    ],
                    [
                        "label" => "Mitgliedschaft",
                        "link" => route('frontend.memebrship.create', 'mitgliedschaft'),
                    ]
                ],
            ],
            [
                "label" => "Legal",
                "menu" => [
                    [
                        "label" => "AGB",
                        "link" => route('frontend.page', 'agb'),
                    ],
                    [
                        "label" => "Datenschutz",
                        "link" => route('frontend.page', 'datenschutz'),
                    ],
                    [
                        "label" => "Impressum",
                        "link" => route('frontend.page', 'impressum'),
                    ]
                ],
            ]
        ];
        return view('components.footer', [
            'navigation' =>  $navifation,
        ]);
    }
}
