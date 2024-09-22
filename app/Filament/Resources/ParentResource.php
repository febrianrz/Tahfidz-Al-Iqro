<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ParentResource\Pages\CreateParent;
use App\Filament\Resources\ParentResource\Pages\EditParent;
use App\Filament\Resources\ParentResource\Pages\ListParents;
use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Models\WaliSantri;
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
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ParentResource extends Resource
{
    protected static ?string $model = WaliSantri::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
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
            ->modifyQueryUsing(function(Builder $query){
                
                if(auth()->user()->hasRole('Superadmin')){
                    return $query->where('id',1);
                }
                
            })
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
            'index' => ListParents::route('/'),
            'create' => CreateParent::route('/create'),
            'edit' => EditParent::route('/{record}/edit'),
        ];
    }

    // region Scopes
    public static function canViewAny(): bool
    {
        return auth()->user()->hasPermission("view", static::getModel());
    }


    public static function canEditAny(): bool
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
