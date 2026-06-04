<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),

                Textarea::make('description'),

                TextInput::make('price')
                    ->numeric(),

                TextInput::make('stock')
                    ->numeric(),

                FileUpload::make('image') // 👈 EKLEDİK
                    ->image()
                    ->directory('products'),
            ]);
    }
}