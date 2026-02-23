<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel; 
use Filament\Notifications\Notification;


class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phoneNumber',
        'role',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }


    public function canAccessPanel(Panel $panel): bool
    {
         // If user is not verified
        if ($this->email_verified_at==0) {
            // Default deny
            Notification::make()
                ->title(__('message.Access Denied!'))
                ->body(__('message.You do not have permission to access this panel!'))
                ->warning()
                ->send();
                return false;
        }
        // Admin panel access
        if ($panel->getId() === 'admin' && $this->role === 'Admin') {
            return true;
        }

        // Shop manager panel access
        if ($panel->getId() === 'shop-manager' && $this->role === 'Shop Manager') {
            $seller = Stor::where('storLoginId', $this->id)->first();

            if ($seller && $seller->deleted_at === null) {
                return true; // Allow access
            } else {
                // Show warning in Filament
                Notification::make()
                    ->title(__('message.Access Denied!'))
                    ->body(__('message.Your store is deleted or not available!'))
                    ->warning()
                    ->send();

                return false; // Deny access
            }
        }

        // Rider panel access
        // dd($this->id);
        if ($panel->getId() === 'rider' && $this->role === 'Rider') {
            $rider = Rider::where('riderLoginId', $this->id)->first();

            if ($rider && $rider->status == '1') {
                return true; // Allow access
            } else {
                // Show warning in Filament
                Notification::make()
                    ->title(__('message.Access Denied!'))
                    ->body(__('message.Your account have been disabled!'))
                    ->warning()
                    ->send();

                return false; // Deny access
            }
        }

        

        return false;
    }


       


    


}
