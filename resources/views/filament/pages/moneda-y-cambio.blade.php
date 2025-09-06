<x-filament::page>
    <div class="space-y-6">
        <div class="rounded-xl border p-6 bg-white">
            <h2 class="text-lg font-semibold mb-4">Configuración de moneda</h2>

            <form wire:submit.prevent="save" class="space-y-4">
                {{ $this->form }}

                <div class="flex items-center justify-end">
                    <x-filament::button type="submit">
                        Guardar
                    </x-filament::button>
                </div>
            </form>

            <p class="text-xs text-gray-500 mt-4">
                Último valor guardado: <strong>{{ number_format($usd_cop_rate, 4) }} COP</strong> por 1 USD
            </p>
        </div>
    </div>
</x-filament::page>
