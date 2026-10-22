<?php

namespace Tests\Feature;

use App\Support\MarketingCatalog;
use Tests\TestCase;

class MarketingSiteTest extends TestCase
{
    public function test_homepage_renders_with_real_navigation(): void
    {
        $html = $this->get('/')->assertOk()->getContent();

        $this->assertStringContainsString('SecureBank', $html);
        $this->assertStringNotContainsString('href="#"', $html, 'Homepage still contains dead placeholder links.');
    }

    public function test_no_public_page_has_dead_placeholder_links(): void
    {
        $uris = ['/', '/login', '/register'];

        foreach (array_keys(MarketingCatalog::all()) as $slug) {
            $uris[] = "/{$slug}";
        }

        foreach ($uris as $uri) {
            $html = $this->get($uri)->assertOk()->getContent();

            $this->assertStringNotContainsString('href="#"', $html, "Dead placeholder link found on {$uri}.");
        }
    }

    public function test_every_marketing_page_renders_successfully(): void
    {
        foreach (array_keys(MarketingCatalog::all()) as $slug) {
            $this->get("/{$slug}")->assertOk();
        }
    }

    public function test_unknown_marketing_slug_returns_not_found(): void
    {
        $this->get('/this-page-does-not-exist')->assertNotFound();
    }

    public function test_application_routes_are_not_shadowed_by_the_catch_all(): void
    {
        $this->get('/login')->assertOk();
        $this->get('/register')->assertOk();
    }

    public function test_catalog_entries_have_no_dangling_related_pages(): void
    {
        foreach (MarketingCatalog::all() as $slug => $page) {
            foreach ($page['related'] ?? [] as $related) {
                $this->assertTrue(
                    MarketingCatalog::exists($related),
                    "Page '{$slug}' links to missing page '{$related}'."
                );
            }
        }
    }
}
