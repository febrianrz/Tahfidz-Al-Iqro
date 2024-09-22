<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Spatie\Permission\Traits\HasRoles;
use Althinect\FilamentSpatieRolesPermissions\Concerns\HasSuperAdmin;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasSuperAdmin, HasRoles, HasSuperAdmin;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class,'student_id');
    }

    public function waliSantri()
    {
        return $this->belongsTo(WaliSantri::class,'parent_id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class,'teacher_id');
    }

    public function hasPermission($checkName, $modelName)
    {
        if (auth()->user()->hasRole('Superadmin')) {
            return true;
        }
        $user = auth()->user()->load('roles.permissions');
        $permissions = $user->roles->pluck('permissions')->flatten()->unique('id');
        $state = false;
        $className = str_replace("App\Models\\",'',get_class(new $modelName));
        $checkName = $checkName." ".$className;
        foreach($permissions as $permission){
            if($permission->name === $checkName){
                $state = true;
            }
        }
        return $state;
    }
}
