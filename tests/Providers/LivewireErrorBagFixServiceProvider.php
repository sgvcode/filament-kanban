<?php

namespace Mokhosh\FilamentKanban\Tests\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\ComponentHookRegistry;
use Mokhosh\FilamentKanban\Tests\Hooks\EnsureErrorBagIsInitialized;

/**
 * Service provider that registers our error bag fix hook BEFORE Livewire's SupportValidation.
 * This hook ensures that getErrorBag() never returns null during render.
 */
class LivewireErrorBagFixServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Register our hook as early as possible
        // This ensures it runs BEFORE SupportValidation
        ComponentHookRegistry::register(EnsureErrorBagIsInitialized::class);
    }
}
