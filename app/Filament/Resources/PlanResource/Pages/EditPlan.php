<?php

namespace App\Filament\Resources\PlanResource\Pages;

use App\Exports\TarifasExport;
use App\Filament\Resources\PlanResource;
use App\Imports\TarifasImport;
use App\Models\TarifaImportLog;
use Filament\Actions;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Maatwebsite\Excel\Facades\Excel;

class EditPlan extends EditRecord
{
    protected static string $resource = PlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Plantilla CSV
            Actions\Action::make('plantilla')
                ->label('Descargar plantilla CSV')
                ->icon('heroicon-m-arrow-down-tray')
                ->action(fn () => response()->streamDownload(function () {
                    echo "dias,valor\n1,600000\n2,80000\n3,90000\n";
                }, 'plantilla_tarifas.csv')),

            // Vista previa (DRY RUN)
            Actions\Action::make('previewTarifas')
                ->label('Vista previa (no escribe)')
                ->icon('heroicon-m-magnifying-glass')
                ->form([
                    Forms\Components\FileUpload::make('file')
                        ->label('Archivo (.xlsx o .csv)')
                        ->disk('local')
                        ->directory('imports/tarifas')
                        ->acceptedFileTypes([
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            'application/vnd.ms-excel',
                            'text/csv',
                            'application/csv',
                            'text/plain',
                        ])
                        ->maxSize(8192) // 8MB
                        ->preserveFilenames()
                        ->required(),
                ])
                ->action(function (array $data) {
                    $plan = $this->record;
                    $fullPath = $this->resolveUploadedPath($data['file']);

                    $import = new TarifasImport($plan->id, dryRun: true);
                    Excel::import($import, $fullPath);

                    $r = $import->getReport();
                    Notification::make()
                        ->title('Vista previa de importación')
                        ->body("Procesadas: {$r['processed']} • Válidas: {$r['valid']} • Errores: {$r['errors']} • Duplicadas/saltadas: {$r['skipped']}")
                        ->success()
                        ->send();
                }),

            // Importar (con reemplazo opcional y cola opcional)
            Actions\Action::make('importarTarifas')
                ->label('Importar Excel (tarifas)')
                ->icon('heroicon-m-arrow-up-tray')
                ->form([
                    Forms\Components\FileUpload::make('file')
                        ->label('Archivo (.xlsx o .csv)')
                        ->disk('local')
                        ->directory('imports/tarifas')
                        ->acceptedFileTypes([
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            'application/vnd.ms-excel',
                            'text/csv',
                            'application/csv',
                            'text/plain',
                        ])
                        ->maxSize(8192)
                        ->preserveFilenames()
                        ->required(),
                    Forms\Components\Toggle::make('reemplazar')
                        ->label('Reemplazar tarifas existentes')
                        ->default(false),
                    Forms\Components\Toggle::make('en_colas')
                        ->label('Procesar en segundo plano (colas)')
                        ->default(false)
                        ->hint('Requiere php artisan queue:work'),
                ])
                ->action(function (array $data) {
                    $plan = $this->record;

                    // Reemplazo (si aplica)
                    if (!empty($data['reemplazar'])) {
                        $plan->tarifas()->delete();
                    }

                    $fullPath = $this->resolveUploadedPath($data['file']);
                    $filename = basename($fullPath);

                    // Log inicial
                    $log = TarifaImportLog::create([
                        'plan_id'  => $plan->id,
                        'user_id'  => Auth::id(),
                        'filename' => $filename,
                        'status'   => !empty($data['en_colas']) ? 'queued' : 'processed',
                    ]);

                    if (!empty($data['en_colas'])) {
                        // En cola (no devuelve reporte inmediato)
                        Excel::queue(new TarifasImport($plan->id, dryRun: false), $fullPath)
                            ->allOnQueue('default')
                            ->chain([
                                // Actualizar log al final
                                function () use ($log) {
                                    $log->update(['status' => 'processed']);
                                }
                            ]);

                        Notification::make()
                            ->title('Importación en cola')
                            ->body('Se está procesando en segundo plano. Asegúrate de ejecutar: php artisan queue:work')
                            ->success()
                            ->send();

                    } else {
                        // Sin cola (reporte inmediato)
                        $import = new TarifasImport($plan->id, dryRun: false);
                        Excel::import($import, $fullPath);

                        $r = $import->getReport();
                        $log->update([
                            'processed' => $r['processed'],
                            'valid'     => $r['valid'],
                            'imported'  => $r['imported'],
                            'skipped'   => $r['skipped'],
                            'errors'    => $r['errors'],
                            'messages'  => array_slice($r['messages'], 0, 30), // guarda hasta 30 mensajes
                        ]);

                        Notification::make()
                            ->title('Tarifas importadas')
                            ->body("Procesadas: {$r['processed']} • Importadas: {$r['imported']} • Errores: {$r['errors']} • Saltadas: {$r['skipped']}")
                            ->success()
                            ->send();

                        $this->fillForm(); // refresca el repeater
                    }
                }),

            // Exportar CSV simple
            Actions\Action::make('exportarCSV')
                ->label('Exportar CSV')
                ->icon('heroicon-m-arrow-down-tray')
                ->color('gray')
                ->action(function () {
                    $plan = $this->record;
                    return response()->streamDownload(function () use ($plan) {
                        echo "dias,valor\n";
                        foreach ($plan->tarifas()->orderBy('dias')->get(['dias','precio']) as $t) {
                            echo "{$t->dias},{$t->precio}\n";
                        }
                    }, "tarifas_plan_{$plan->id}.csv");
                }),

            // Exportar XLSX con formato
            Actions\Action::make('exportarXLSX')
                ->label('Exportar XLSX')
                ->icon('heroicon-m-arrow-down-tray')
                ->color('gray')
                ->action(function () {
                    $plan = $this->record;
                    return Excel::download(new TarifasExport($plan), "tarifas_plan_{$plan->id}.xlsx");
                }),
        ];
    }

    /** Resuelve FileUpload a ruta absoluta dentro de storage/app */
    protected function resolveUploadedPath($uploaded): string
    {
        if ($uploaded instanceof TemporaryUploadedFile) {
            $stored = $uploaded->store('imports/tarifas', 'local');
            return Storage::disk('local')->path($stored);
        }
        if ($uploaded instanceof UploadedFile) {
            $stored = $uploaded->store('imports/tarifas', ['disk' => 'local']);
            return Storage::disk('local')->path($stored);
        }
        if (is_string($uploaded)) {
            return Storage::disk('local')->path($uploaded);
        }
        throw new \RuntimeException('Archivo no válido.');
    }
}
