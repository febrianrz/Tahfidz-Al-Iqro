<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = "Santri";

    protected static ?string $modelLabel = 'Santri';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('parent_id')
                    ->relationship('waliSantri', 'name')
                    ->searchable()
                    ->preload(),
                TextInput::make('name')
                    ->autofocus()
                    ->required()
                    ->placeholder(__('Name')),
                DatePicker::make('born_at')
                    ->required()
                    ->placeholder(__('Date Of Birth')),
                Select::make('gender')
                    ->options([
                        'Male' => 'Male',
                        'Female' => 'Female',
                    ])
                    ->preload(),
                TextInput::make('address')
                    ->required()
                    ->placeholder(__('Address')),
                Select::make('status')
                    ->options([
                        'Active' => 'Active',
                        'Inactive' => 'Inactive',
                    ])
                    ->preload(),
                FileUpload::make('photo')
                    ->avatar()
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('waliSantri.name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('born_at')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('gender')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->searchable()
                    ->sortable(),
                ImageColumn::make('photo')
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
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
            'view' => Pages\DetailStudentPage::route('/{record}/detail'),
        ];
    }

    public static function getPluralLabel(): ?string
    {
        return 'Santri';
    }

    public static function getEloquentQuery(): Builder
    {
        if(!auth()->user()->hasRole('Superadmin')){
            return parent::getEloquentQuery()->where('parent_id',auth()->user()->parent_id);
        }
        return parent::getEloquentQuery();
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
