<?php

namespace App\Support;

use App\Support\Content\BankingContent;
use App\Support\Content\BusinessContent;
use App\Support\Content\CardsContent;
use App\Support\Content\CompanyContent;
use App\Support\Content\InvestingContent;
use App\Support\Content\LendingContent;
use App\Support\Content\LegalContent;
use App\Support\Content\SupportContent;
use App\Support\Content\ToolsContent;

class MarketingCatalog
{
    /** @var array<string, array<string, mixed>>|null */
    protected static ?array $cache = null;

    /**
     * Every marketing page, keyed by URL slug.
     *
     * @return array<string, array<string, mixed>>
     */
    public static function all(): array
    {
        if (static::$cache !== null) {
            return static::$cache;
        }

        $merged = array_merge(
            BankingContent::pages(),
            CardsContent::pages(),
            LendingContent::pages(),
            InvestingContent::pages(),
            BusinessContent::pages(),
            SupportContent::pages(),
            CompanyContent::pages(),
            ToolsContent::pages(),
            LegalContent::pages(),
        );

        // Deterministic ordering, longest slug first for the route constraint.
        uksort($merged, static fn ($a, $b) => strlen($b) <=> strlen($a) ?: strcmp($a, $b));

        return static::$cache = $merged;
    }

    public static function get(string $slug): ?array
    {
        return static::all()[$slug] ?? null;
    }

    public static function exists(string $slug): bool
    {
        return array_key_exists($slug, static::all());
    }

    /**
     * Regex alternation of every valid slug, escaped and ordered longest-first
     * so the route constraint never partially matches a longer slug.
     */
    public static function slugPattern(): string
    {
        $slugs = array_map(
            static fn (string $slug) => preg_quote($slug, '#'),
            array_keys(static::all())
        );

        usort($slugs, static fn ($a, $b) => strlen($b) <=> strlen($a));

        return implode('|', $slugs);
    }

    /**
     * Resolve a possibly-partial link label to a slug.
     * Falls back to the first page in the same navigation group.
     */
    public static function resolve(?string $label, ?string $fallbackGroup = null): ?string
    {
        if ($label === null) {
            return null;
        }

        $needle = static::normalize($label);
        $pages = static::all();

        foreach ($pages as $slug => $page) {
            if (static::normalize($page['title']) === $needle) {
                return $slug;
            }
        }

        foreach ($pages as $slug => $page) {
            foreach (($page['keywords'] ?? []) as $keyword) {
                if (static::normalize($keyword) === $needle) {
                    return $slug;
                }
            }
        }

        if ($fallbackGroup !== null) {
            foreach ($pages as $slug => $page) {
                if (($page['group'] ?? null) === $fallbackGroup) {
                    return $slug;
                }
            }
        }

        return null;
    }

    /**
     * Resolve a link label or slug to a URL.
     *
     * Falls back to a group hub so a link never renders as a dead "#".
     */
    public static function url(?string $label, string $fallback = 'banking'): string
    {
        if ($label === null || $label === '') {
            return route('marketing.show', $fallback);
        }

        $slug = static::exists($label) ? $label : static::resolve($label, $fallback);

        return route('marketing.show', $slug ?? $fallback);
    }

    protected static function normalize(string $value): string
    {
        return strtolower(trim((string) preg_replace('/[^a-z0-9]+/i', ' ', $value)));
    }

    /**
     * Shared page factory so each entry stays compact and consistent.
     *
     * @param  list<array{0:string,1:string}>  $highlights
     * @param  list<array{0:string,1:string}>  $features
     * @param  list<array{0:string,1:string}>  $faq
     * @param  list<string>  $related
     * @param  list<string>  $keywords
     * @return array<string, mixed>
     */
    public static function page(
        string $group,
        string $eyebrow,
        string $title,
        string $lede,
        array $highlights = [],
        array $features = [],
        array $faq = [],
        array $related = [],
        array $keywords = [],
        string $type = 'product',
        ?string $ctaLabel = null,
        ?string $ctaRoute = 'register',
    ): array {
        return [
            'group' => $group,
            'type' => $type,
            'eyebrow' => $eyebrow,
            'title' => $title,
            'lede' => $lede,
            'highlights' => $highlights,
            'features' => $features,
            'faq' => $faq,
            'related' => $related,
            'keywords' => $keywords,
            // Resolved to a URL in the controller. The catalog is built while
            // routes are still being registered, so it must not call route().
            'cta' => [
                'label' => $ctaLabel ?? 'Open an Account',
                'route' => $ctaRoute ?? 'register',
            ],
        ];
    }

    /** @return array<string, array<string, mixed>> */
    public static function hub(
        string $group,
        string $eyebrow,
        string $title,
        string $lede,
        array $sections,
        array $faq = [],
        string $type = 'hub',
        array $keywords = [],
        ?string $ctaLabel = null,
        ?string $ctaRoute = 'register',
    ): array {
        return self::page(
            $group,
            $eyebrow,
            $title,
            $lede,
            [],
            $sections,
            $faq,
            [],
            $keywords,
            $type,
            $ctaLabel,
            $ctaRoute,
        );
    }
}
