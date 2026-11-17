<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MarketingPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_marketing_routes_respond(): void
    {
        foreach (['/', '/features', '/modules', '/checklists', '/reports', '/pricing', '/demo'] as $uri) {
            $this->get($uri)->assertOk();
        }
    }
}
