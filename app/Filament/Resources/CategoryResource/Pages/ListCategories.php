<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use App\Imports\CategoryImport;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ListCategories extends ListRecords
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->keyBindings(['command+alt+n', 'ctrl+alt+n']),

            Action::make('Import')
                ->label('Import')
                ->icon('heroicon-s-cloud-arrow-up')
                ->form([
                    FileUpload::make('file')
                        ->label('Upload CSV')
                ])
                ->action(function (array $data) {
                    // $path = asset(Storage::url($data['file']));
                    $path = public_path('storage/' . $data['file']);

                    // dd($path);

                    Excel::import(new CategoryImport, $path);

                    Notification::make()
                        ->title('Category Imported successfully')
                        ->success()
                        ->send();
                })

                ->color('success'),
        ];
    }
}
