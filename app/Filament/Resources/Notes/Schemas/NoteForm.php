<?php

namespace App\Filament\Resources\Notes\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class NoteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                Textarea::make('content')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('folder_id')
                    ->numeric(),
                TextInput::make('noteable_type')
                    ->required(),
                TextInput::make('noteable_id')
                    ->required()
                    ->numeric(),
                TextInput::make('visibility')
                    ->required()
                    ->default('private'),
            ]);
    }
}
