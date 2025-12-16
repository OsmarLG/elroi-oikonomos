<?php

namespace App\Filament\Resources\Folders\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class FolderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('parent_id')
                    ->numeric(),
                TextInput::make('folderable_type')
                    ->required(),
                TextInput::make('folderable_id')
                    ->required()
                    ->numeric(),
                TextInput::make('visibility')
                    ->required()
                    ->default('private'),
            ]);
    }
}
