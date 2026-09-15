I now have a full picture. Let me write the implementation spec.

---

# Implementation Specification: „Mein Konto" Navigation Item

**Ticket:** 86ca0hmvt  
**Author:** Charlotte Bott  
**Date:** 2026-05-28

---

## 1. Context

The frontend main navigation is built dynamically in `app/Livewire/FrontendTopNavigation.php` and rendered in `resources/views/livewire/frontend-top-navigation.blade.php`. The template iterates a `$navigation` array passed from the Livewire component; each item is either a direct link or a dropdown with a `submenu` array.

**Current state:** The `buildNavidation()` method already contains a "Mein Konto" entry at position 9 (lines 136–141), making it the last item. The entry is auth-aware: guests see "Einloggen" + "Konto Erstellen"; authenticated customers (`Auth::guard('customer')`) see "Mein konto" + "Logout". All four named routes (`frontend.konto`, `frontend.login`, `frontend.register`, `frontend.logout`) are registered in `routes/web.php`.

**What the ticket is actually about:** The entry exists in code but must be verified to render correctly in both desktop and mobile layouts, respond to login/logout state changes, and present the correct label casing ("MEIN KONTO" uppercase visually, matching all other nav items).

---

## 2. Requirements

### Functional
| # | Requirement |
|---|-------------|
| F1 | "Mein Konto" appears as the rightmost item in the desktop navigation bar |
| F2 | It renders as a dropdown with context-aware submenu: unauthenticated → [Einloggen, Konto Erstellen]; authenticated → [Mein Konto, Logout] |
| F3 | The Logout item submits a POST form to `frontend.logout` (CSRF-protected); it must not be a GET link |
| F4 | After a customer logs in via Livewire (`loggedIn` event), the nav updates to show the authenticated submenu without a full page reload |
| F5 | After a customer logs out, the nav updates to show the guest submenu |
| F6 | "Mein Konto" appears in the mobile menu with the same context-aware submenu logic |

### Non-Functional
| # | Requirement |
|---|-------------|
| N1 | No additional database queries beyond the existing `CourseCategory` query |
| N2 | Visual style consistent with all other nav items (uppercase, `text-sm font-semibold text-white`) |
| N3 | Dropdown must close on outside click (already handled by Alpine.js `@click.away`) |

---

## 3. Implementation Plan

### Step 1 — Verify existing "Mein Konto" entry renders

**File:** `app/Livewire/FrontendTopNavigation.php`  
**Lines:** 136–141

The entry already exists. No structural change needed. Confirm it is included in the `collect([...])` return and not accidentally excluded by a stale feature flag or environment condition.

### Step 2 — Add `loggedOut` event listener

**File:** `app/Livewire/FrontendTopNavigation.php`

Currently `refresh()` (line 14–18) only listens to `loggedIn`. When a customer logs out, the nav stays showing the authenticated menu until the next full page load. Add a second listener:

```php
#[On('loggedOut')]
public function refresh(): void
{
    $this->navigation = $this->buildNavidation();
}
```

The logout route at `routes/web.php:94` must dispatch this event from the corresponding controller/action. Locate the logout handler and add `$this->dispatch('loggedOut')` if it is a Livewire component, or redirect back (which triggers a full page load — acceptable fallback if not Livewire-driven).

### Step 3 — Fix label casing in authenticated submenu

**File:** `app/Livewire/FrontendTopNavigation.php`, line 148  

`"label" => 'Mein konto'` (lowercase k) should be `'Mein Konto'` to match the parent label and the dashboard tab label seen in `customer-dashboard.blade.php:23`.

```php
// Before
"label" => 'Mein konto',

// After
"label" => 'Mein Konto',
```

### Step 4 — Confirm mobile menu renders the item

**File:** `resources/views/livewire/frontend-top-navigation.blade.php`  
**Lines:** 104–152

The mobile menu iterates `$navigation` identically to the desktop menu and handles the `submenu` case. No template change is needed; visually verify on a viewport < 768 px.

### Step 5 — Fix method name typo (non-blocking, low-risk)

`buildNavidation` → `buildNavigation`. Rename in both the private method declaration and its two call sites (`mount` and `refresh`). This is cosmetic but improves maintainability. Only do this if a dedicated refactor commit is acceptable, since it touches three lines.

---

## 4. Data Models / Interfaces

### Navigation item shape (PHP array, no formal type)

```php
// Simple link
[
    'label'    => string,   // display text
    'link'     => string,   // absolute URL from route()
    'position' => int,      // sort key
]

// Dropdown
[
    'label'    => string,
    'submenu'  => array<NavigationItem>,  // link or form items
    'position' => int,
]

// Form action (used for Logout only)
[
    'label'  => string,
    'form'   => true,
    'action' => string,   // POST URL
]
```

### Relevant routes

| Name | Method | URI | Guard |
|---|---|---|---|
| `frontend.login` | GET | `/login` | — |
| `frontend.register` | GET | `/register` | — |
| `frontend.konto` | GET | `/konto` | `customer.auth` |
| `frontend.logout` | POST | `/logout` | `customer.auth` |

### Auth guard

`Auth::guard('customer')` — separate from the default `web` guard. The Livewire component must check this guard, not `Auth::check()`, which applies to the admin guard.

---

## 5. Edge Cases & Error Handling

| Scenario | Current behaviour | Required handling |
|---|---|---|
| Customer logs out via Livewire | Nav still shows authenticated menu | Dispatch `loggedOut` event; `refresh()` rebuilds nav (Step 2) |
| Customer logs out via direct POST (non-Livewire) | Full page redirect — nav rebuilds automatically | No change needed |
| `frontend.konto` route hit by unauthenticated user | `customer.auth` middleware redirects to login | No nav change needed; middleware handles it |
| `route('frontend.coupon', 'gutsheine')` typo on line 116 | Resolves if route accepts slug parameter | Out of scope for this ticket |
| `frontend.logout` route called without CSRF | Laravel 419 response | Ensured by `@csrf` in the form template (line 49) |
| User resizes from mobile to desktop after opening mobile menu | Alpine `mobileMenuOpen` state remains `true` | Already handled: desktop menu is a separate DOM branch hidden via `md:hidden` |

---

## 6. Testing Considerations

### Unit / Feature tests

1. **`FrontendTopNavigationTest::test_guest_sees_login_and_register_in_mein_konto_submenu`**  
   Mount the Livewire component without authenticating via `customer` guard. Assert `$navigation` contains an item with `label === 'Mein Konto'` whose `submenu` has exactly two entries: "Einloggen" and "Konto Erstellen", each with valid route URLs.

2. **`FrontendTopNavigationTest::test_authenticated_customer_sees_dashboard_and_logout`**  
   Use `actingAs($customer, 'customer')`. Assert the "Mein Konto" submenu contains "Mein Konto" (dashboard link) and "Logout" (form action).

3. **`FrontendTopNavigationTest::test_refresh_rebuilds_navigation_on_loggedIn_event`**  
   Mount as guest. Authenticate. Dispatch `loggedIn` event via `$component->dispatch('loggedIn')`. Assert submenu flips to authenticated state.

4. **`FrontendTopNavigationTest::test_refresh_rebuilds_navigation_on_loggedOut_event`** *(new)*  
   Mount as authenticated customer. Dispatch `loggedOut`. Assert submenu flips to guest state.

5. **`FrontendTopNavigationTest::test_mein_konto_is_last_nav_item`**  
   Assert that after `sortBy('position')` the last item in `$navigation` has `label === 'Mein Konto'`.

### Browser / manual verification checklist

- [ ] Desktop (≥ 768 px): "MEIN KONTO" visible as last nav item, dropdown opens on click, closes on outside click
- [ ] Desktop guest: dropdown shows "Einloggen" and "Konto Erstellen" links
- [ ] Desktop authenticated: dropdown shows "Mein Konto" link and "Logout" POST button
- [ ] Mobile (< 768 px): hamburger opens mobile menu; "Mein Konto" appears last with collapsible sub-items
- [ ] Login flow: after logging in, nav updates without page reload (Livewire `loggedIn` event)
- [ ] Logout flow: after logging out, nav updates to guest state

### Test infrastructure notes

- Use `Livewire::test(FrontendTopNavigation::class)` from the `livewire/livewire` test helper
- The `customer` guard requires a separate `Customer` factory; confirm it exists before writing tests
- `CourseCategory` records with `status = true` must be seeded in the test DB to avoid the `Kurse` submenu being empty, which does not affect the "Mein Konto" assertions but avoids noise

---