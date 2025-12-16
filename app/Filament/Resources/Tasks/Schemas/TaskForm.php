<?php

namespace App\Filament\Resources\Tasks\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class TaskForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                Toggle::make('completed')
                    ->required(),
                TextInput::make('project_id')
                    ->numeric(),
            ]);
    }
}
