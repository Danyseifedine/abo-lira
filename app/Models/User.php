<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Danyseifeddine\Keychain\Traits\HasSocialAccounts;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasSocialAccounts, InteractsWithMedia, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'is_active',
        'email',
        'password',
        'email_verified_at',
        'avatar',
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
     * Accessors that should be appended to the model's array and JSON form.
     *
     * @var list<string>
     */
    protected $appends = [
        'avatar_url',
    ];

    protected $with = [
        'media',
        'roles',
        'permissions',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')
            ->singleFile()
            ->useDisk('public')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp']);
    }

    public function getAvatarUrlAttribute(): string
    {
        $url = $this->getFirstMediaUrl('avatar');

        // Return default image if no avatar exists
        return $url ?: asset('assets/images/default.jpg');
    }

    public function setAvatarAttribute($value): void
    {
        if ($value === 'remove') {
            // Remove existing avatar and set to default
            $this->clearMediaCollection('avatar');
        } elseif ($value) {
            // Add new avatar file
            $this->clearMediaCollection('avatar');
            $this->addMediaFromRequest('avatar')->toMediaCollection('avatar');
        }
    }
}
