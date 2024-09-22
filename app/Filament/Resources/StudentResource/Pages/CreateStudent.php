<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Filament\Resources\StudentResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\WaliSantri;

class CreateStudent extends CreateRecord
{
    protected static string $resource = StudentResource::class;
    public WaliSantri $waliSantri;

    public function __construct()
    {
           
    }
}
