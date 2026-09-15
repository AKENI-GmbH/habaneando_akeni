<?php

namespace Tests\Feature;

use App\Livewire\FrontendTopNavigation;
use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class FrontendTopNavigationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_sees_login_and_register_in_mein_konto_submenu(): void
    {
        $component = Livewire::test(FrontendTopNavigation::class);

        $navigation = collect($component->get('navigation'));
        $meinKonto  = $navigation->firstWhere('label', 'Mein Konto');

        $this->assertNotNull($meinKonto);
        $labels = array_column($meinKonto['submenu'], 'label');
        $this->assertContains('Einloggen', $labels);
        $this->assertContains('Konto Erstellen', $labels);
        $this->assertCount(2, $meinKonto['submenu']);
    }

    public function test_authenticated_customer_sees_dashboard_and_logout(): void
    {
        $customer = Customer::factory()->create();

        $component = Livewire::actingAs($customer, 'customer')
            ->test(FrontendTopNavigation::class);

        $navigation = collect($component->get('navigation'));
        $meinKonto  = $navigation->firstWhere('label', 'Mein Konto');

        $this->assertNotNull($meinKonto);

        $labels = array_column($meinKonto['submenu'], 'label');
        $this->assertContains('Mein Konto', $labels);
        $this->assertContains('Logout', $labels);

        $logout = collect($meinKonto['submenu'])->firstWhere('label', 'Logout');
        $this->assertTrue($logout['form']);
        $this->assertArrayHasKey('action', $logout);
    }

    public function test_authenticated_submenu_label_uses_correct_casing(): void
    {
        $customer = Customer::factory()->create();

        $component = Livewire::actingAs($customer, 'customer')
            ->test(FrontendTopNavigation::class);

        $navigation = collect($component->get('navigation'));
        $meinKonto  = $navigation->firstWhere('label', 'Mein Konto');
        $dashboardItem = collect($meinKonto['submenu'])->firstWhere('label', 'Mein Konto');

        $this->assertSame('Mein Konto', $dashboardItem['label']);
    }

    public function test_refresh_rebuilds_navigation_on_loggedIn_event(): void
    {
        $customer = Customer::factory()->create();

        $component = Livewire::test(FrontendTopNavigation::class);

        $navigation = collect($component->get('navigation'));
        $meinKonto  = $navigation->firstWhere('label', 'Mein Konto');
        $labels     = array_column($meinKonto['submenu'], 'label');
        $this->assertContains('Einloggen', $labels);

        $this->actingAs($customer, 'customer');
        $component->dispatch('loggedIn');

        $navigation = collect($component->get('navigation'));
        $meinKonto  = $navigation->firstWhere('label', 'Mein Konto');
        $labels     = array_column($meinKonto['submenu'], 'label');
        $this->assertContains('Mein Konto', $labels);
    }

    public function test_refresh_rebuilds_navigation_on_loggedOut_event(): void
    {
        $customer = Customer::factory()->create();

        $component = Livewire::actingAs($customer, 'customer')
            ->test(FrontendTopNavigation::class);

        $navigation = collect($component->get('navigation'));
        $meinKonto  = $navigation->firstWhere('label', 'Mein Konto');
        $labels     = array_column($meinKonto['submenu'], 'label');
        $this->assertContains('Mein Konto', $labels);

        $this->app['auth']->guard('customer')->logout();
        $component->dispatch('loggedOut');

        $navigation = collect($component->get('navigation'));
        $meinKonto  = $navigation->firstWhere('label', 'Mein Konto');
        $labels     = array_column($meinKonto['submenu'], 'label');
        $this->assertContains('Einloggen', $labels);
    }

    public function test_mein_konto_is_last_nav_item(): void
    {
        $component = Livewire::test(FrontendTopNavigation::class);

        $navigation = collect($component->get('navigation'))
            ->sortBy('position')
            ->values();

        $last = $navigation->last();
        $this->assertSame('Mein Konto', $last['label']);
    }
}
