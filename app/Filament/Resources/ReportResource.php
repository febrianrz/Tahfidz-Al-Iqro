<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportResource\Pages;
use App\Filament\Resources\ReportResource\RelationManagers;
use App\Models\Report;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReportResource extends Resource
{
    protected static ?string $model = Report::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('student_id')
                    ->searchable()
                    ->relationship('student', 'name')
                    ->preload(),
                Select::make('teacher_id')
                    ->searchable()
                    ->relationship('teacher', 'name')
                    ->preload(),
                Select::make('type')
                    ->searchable()
                    ->options([
                        'Harian' => 'Harian',
                        'Tasmi' => 'Tasmi',
                        'Per Juz' => 'Per Juz',
                    ]),
                DatePicker::make('date')
                    ->required(),
                TextInput::make('score')
                    ->numeric()
                    ->required(),
                Textarea::make('notes'),
                Select::make('status')
                    ->options([
                        'Ikut Laporan' => 'Ikut Laporan',
                        'Tidak Ikut Laporan' => 'Tidak Ikut Laporan',
                    ])
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('student.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('teacher.name')
                    ->searchable()
                    ->sortable(), 
                TextColumn::make('type')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('date')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('score')
                    ->searchable()
                    ->sortable(), 
                TextColumn::make('status')
                    ->searchable()
                    ->sortable(),  
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListReports::route('/'),
            'create' => Pages\CreateReport::route('/create'),
            'edit' => Pages\EditReport::route('/{record}/edit'),
        ];
    }

    // region Scopes
    public static function canViewAny(): bool
    {
        return auth()->user()->hasPermission("view", static::getModel());
    }


    public static function canEdit(Model $record): bool
    {
        return auth()->user()->hasPermission("update", static::getModel());
    }

    
    public static function canDeleteAny(): bool
    {
        return auth()->user()->hasPermission("delete", static::getModel());
    }

    public static function canCreate(): bool
    {
        return auth()->user()->hasPermission("create", static::getModel());
    }
}
