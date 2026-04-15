<?php

namespace Mokhosh\FilamentKanban\Tests\Hooks;

use Illuminate\Support\MessageBag;
use Livewire\ComponentHook;

/**
 * Livewire hook that ensures error bag is initialized before render.
 * This is a workaround for a Livewire 4.x bug where getErrorBag() can return null.
 * 
 * IMPORTANT: This hook MUST be registered BEFORE SupportValidation to work correctly.
 */
class EnsureErrorBagIsInitialized extends ComponentHook
{
    public function render($view, $data)
    {
        // Ensure error bag is never null during render
        // This must happen BEFORE SupportValidation::render() runs
        try {
            $bag = $this->component->getErrorBag();
            
            if ($bag === null) {
                $this->component->setErrorBag([]);
            }
        } catch (\Throwable $e) {
            // If getErrorBag throws an error, just set an empty bag
            $this->component->setErrorBag([]);
        }
    }
}
