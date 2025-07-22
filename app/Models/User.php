<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Contracts\Viewable;
use App\Enums\UserMailPreference;
use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @property string $email
 * @property mixed $avatar
 * @property mixed $settings
 * @property mixed $gradient
 * @property mixed $questionsReceived
 * @property mixed $questionsSent
 * @property mixed $username
 * @method static whereIn(string $string, array $mentions)
 */
class User extends Authenticatable implements FilamentUser,MustVerifyEmail,Viewable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public static function incrementViews(array $ids)
    : void
    {
        self::withoutTimestamps(function () use ($ids)
        : void
        {
            self::query()
                ->whereIn('id', $ids)
                ->increment('views');
        });
    }

    public function canAccessPanel(Panel $panel)
    : bool
    {
        return $this->hasVerifiedEmail() && ($this->email === 'erconyango@gmail.com' || $this->email === 'ke.3rion@gmail.com');
    }

    public function bookmarks()
    : HasMany
    {
        return $this->hasMany(Bookmark::class);
    }

    public function links()
    : HasMany
    {
        return $this->hasMany(Link::class);
    }

    public function questionsSent()
    : HasMany
    {
        return $this->hasMany(Question::class, 'from_id');
    }

    public function questionsReceived()
    : HasMany
    {
        return $this->hasMany(Question::class, 'to_id');
    }

    public function pinnedQuestion()
    : HasOne
    {
        return $this->hasOne(Question::class, 'to_id')
            ->where('pinned', true);
    }

    public function followers()
    : BelongsToMany
    {
        return $this->belongsToMany(self::class, 'followers', 'user_id', 'follower_id');
    }

    public function following()
    : BelongsToMany
    {
        return $this->belongsToMany(self::class, 'followers', 'follower_id', 'user_id');

    }

    public function getAvatarUrlAttribute()
    : string
    {
        return $this->avatar ? Storage::disk('public')->url($this->avatar) : asset('img/default-avatar.png');
    }

    public function getLinksSortAttribute(?string $value)
    : array
    {
        if ($value === null)
        {
            return [];
        }

        $sorting = json_decode($value, true);

        return collect($sorting)
            ->map(fn(string $linkId)
            : int => (int)$linkId)
            ->values()
            ->all();
    }

    public function getRightColorAttribute()
    : string
    {
        return str($this->gradient)
            ->match('/to-.*?\d{3}/')
            ->after('to-')
            ->value();
    }

    /**
     * Set the user's left color attribute.
     */
    public function getLeftColorAttribute()
    : string
    {
        return str($this->gradient)
            ->match('/from-.*?\d{3}/')
            ->after('from-')
            ->value();
    }

    /**
     * Get the user's shape attribute.
     */
    public function getLinkShapeAttribute()
    : string
    {
        $settings = $this->settings ?: [];

        $linkShape = data_get($settings, 'link_shape', 'rounded-lg');

        return is_string($linkShape) ? $linkShape : 'rounded-lg';
    }

    /**
     * Get the user's gradient attribute.
     */
    public function getGradientAttribute()
    : string
    {
        $settings = $this->settings ?: [];

        $gradient = data_get($settings, 'gradient', 'from-blue-500 to-purple-600');

        return is_string($gradient) ? $gradient : 'from-blue-500 to-purple-600';
    }

    /**
     * Purge the user's account.
     */
    public function purge()
    : void
    {
        if ($this->avatar)
        {
            Storage::disk('public')->delete($this->avatar);
        }

        $this->followers()->detach();
        $this->following()->detach();

        $this->notifications()->delete();

        $this->questionsReceived->each->delete();
        $this->questionsSent->each->delete();

        $this->delete();
    }

    /**
     * Get the user's "is_verified" attribute.
     */
    public function getIsVerifiedAttribute(bool $isVerified)
    : bool
    {
        if (collect(config()->array('sponsors.github_usernames'))->contains($this->username))
        {
            return true;
        }

        if (collect(config()->array('sponsors.github_company_usernames'))->contains($this->username))
        {
            return true;
        }

        return $isVerified;
    }

    /**
     * Get the user's "is_company_verified" attribute.
     */
    public function getIsCompanyVerifiedAttribute(bool $isCompanyVerified)
    : bool
    {
        if (collect(config()->array('sponsors.github_company_usernames'))->contains($this->username))
        {
            return true;
        }

        return $isCompanyVerified;
    }

    /**
     * Get the user's bio attribute.
     */
    public function getParsedBioAttribute()
    : HtmlString
    {
        return new HtmlString((new ParsableBio)->parse((string)$this->bio));
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts()
    : array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'email_verified_at' => 'datetime',
            'two_factor_confirmed_at' => 'datetime',
            'is_verified' => 'boolean',
            'is_company_verified' => 'boolean',
            'password' => 'hashed',
            'settings' => 'array',
            'prefers_anonymous_questions' => 'boolean',
            'avatar_updated_at' => 'datetime',
            'mail_preference_time' => UserMailPreference::class,
            'views' => 'integer',
            'is_uploaded_avatar' => 'boolean',
        ];
    }
}
