<?php

namespace App\Http\Controllers;

use App\Support\MarketingCatalog;
use Illuminate\Contracts\View\View;

class MarketingController extends Controller
{
    /**
     * Display a content-backed marketing page.
     *
     * The route constraint already limits the slug to known pages, so a miss
     * here means the catalog and the constraint have drifted apart.
     */
    public function show(string $page): View
    {
        $content = MarketingCatalog::get($page);

        abort_if($content === null, 404);

        $related = [];

        foreach ($content['related'] ?? [] as $slug) {
            if ($item = MarketingCatalog::get($slug)) {
                $related[$slug] = $item;
            }
        }

        $siblings = array_filter(
            MarketingCatalog::all(),
            static fn (array $item) => $item['group'] === $content['group']
        );

        // Breadcrumb parent: the hub page for this group, when one exists.
        $groupHub = null;
        foreach ($siblings as $slug => $item) {
            if ($item['type'] === 'hub' && $slug !== $page) {
                $groupHub = $slug;
                break;
            }
        }

        return view('marketing.show', [
            'page' => $page,
            'content' => $content,
            'related' => $related,
            'siblings' => $siblings,
            'groupHub' => $groupHub,
            'ctaHref' => $this->href($content['cta']['route']),
            'contactHref' => route('marketing.show', 'contact-us'),
        ]);
    }

    /**
     * Resolve a CTA target, which may be a named route or a marketing slug.
     */
    protected function href(string $target): string
    {
        return MarketingCatalog::exists($target)
            ? route('marketing.show', $target)
            : route($target);
    }
}
