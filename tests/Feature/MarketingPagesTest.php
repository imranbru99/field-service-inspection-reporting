<?php

namespace Tests\Feature;

use Tests\TestCase;

class MarketingPagesTest extends TestCase
{
    public function test_marketing_routes_respond(): void
    {
        foreach (['/', '/features', '/modules', '/checklists', '/reports', '/pricing', '/demo'] as $uri) {
            $this->get($uri)->assertOk();
        }
    }
}
