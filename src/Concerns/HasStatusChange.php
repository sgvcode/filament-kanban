<?php

namespace Mokhosh\FilamentKanban\Concerns;

use Livewire\Attributes\On;

/**
 * Fallback for Livewire 4.x in Filament 5.x where #[On] attributes in traits may not be discovered.
 * This method is used as fallback when attribute-based listeners fail to register.
 */
trait HasStatusChange
{
    /**
     * Get event listeners for this component.
     * This is the fallback mechanism for Livewire 4.x.
     */
    public function getListeners(): array
    {
        return [
            'status-changed' => 'onStatusChanged',
            'sort-changed' => 'onSortChanged',
        ];
    }

    #[On('status-changed')]
    public function statusChanged(int | string $recordId, string $status, array $fromOrderedIds, array $toOrderedIds): void
    {
        $this->onStatusChanged($recordId, $status, $fromOrderedIds, $toOrderedIds);
    }

    public function onStatusChanged(int | string $recordId, string $status, array $fromOrderedIds, array $toOrderedIds): void
    {
        $this->getEloquentQuery()->find($recordId)->update([
            static::$recordStatusAttribute => $status,
        ]);

        if (method_exists(static::$model, 'setNewOrder')) {
            static::$model::setNewOrder($toOrderedIds);
        }
    }

    #[On('sort-changed')]
    public function sortChanged(int | string $recordId, string $status, array $orderedIds): void
    {
        $this->onSortChanged($recordId, $status, $orderedIds);
    }

    public function onSortChanged(int | string $recordId, string $status, array $orderedIds): void
    {
        if (method_exists(static::$model, 'setNewOrder')) {
            static::$model::setNewOrder($orderedIds);
        }
    }
}
