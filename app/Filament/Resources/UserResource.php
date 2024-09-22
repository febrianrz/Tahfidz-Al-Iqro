<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->autofocus()
                    ->required()
                    ->placeholder(__('Name')),
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->placeholder(__('Email')),
                TextInput::make('password')
                    ->password()
                    ->required(fn($context)=> $context == 'create'),
                Select::make('roles')
                    ->multiple()
                    ->relationship('roles', 'name')
                    ->preload(),

                Select::make('teacher_id')
                    ->relationship('teacher', 'name')
                    ->searchable()
                    ->preload(),
                Select::make('parent_id')
                    ->relationship('waliSantri', 'name')
                    ->searchable()
                    ->preload(),
                Select::make('student_id')
                    ->relationship('student', 'name')
                    ->searchable()
                    ->preload(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('teacher.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('waliSantri.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('student.name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('roles.name')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Superadmin' => 'danger',
                        'Wali Santri' => 'warning',
                        'Halaqoh' => 'info',
                        'Santri' => 'primary',
                    })
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    // region Scopes
    public static function canViewAny(): bool
    {
        $user = auth()->user();
        if ($user->hasRole('Superadmin')) {
            return true;
        }
        return auth()->user()->can('viewAny', static::getModel());   
    }


    public static function canEditAny(): bool
    {
        $user = auth()->user();
        if ($user->hasRole('Superadmin')) {
            return true;
        }
        return auth()->user()->can('updateAny', static::getModel());   
    }

    public static function canDeleteAny(): bool
    {
        $user = auth()->user();
        if ($user->hasRole('Superadmin')) {
            return true;
        }
        return auth()->user()->can('deleteAny', static::getModel());   
    }
    
}
