{{-- <x-filament-panels::page>
</x-filament-panels::page> --}}
<x-filament::page>
    <div class="flex w-full gap-6">
        <!-- LEFT FILTER SIDEBAR -->
        <div class="w-64 shrink-0">
            <div class="sticky top-20">
                {{ $this->tableFiltersForm }}
            </div>
        </div>

        <!-- RIGHT TABLE (FULL WIDTH) -->
        <div class="flex-1">
            {{ $this->table }}
        </div>
    </div>
</x-filament::page>
