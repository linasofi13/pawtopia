<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /**
     * USER ATTRIBUTES
     * $this->attributes['id'] - int - contains the user primary key (id)
     * $this->attributes['name'] - string - contains the user name
     * $this->attributes['email'] - string - contains the user email
     * $this->attributes['password'] - string - contains the user password
     * $this->attributes['image'] - string - contains the user profile image path
     * $this->attributes['address'] - string - contains the user address
     * $this->attributes['credit_card'] - string - contains the user credit card information
     * $this->attributes['created_at'] - timestamp - contains the user creation date
     * $this->attributes['updated_at'] - timestamp - contains the user update date
     * $this->attributes['favList'] - array - contains the list of favorite products
     *
     * $this->attributes['role'] - string - contains the user role
     *  $this->orders - Order[] - contains the associated orders
     */
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
        'address',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'credit_card',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getRole(): string
    {
        return $this->attributes['role'];
    }

    public function setRole(string $role): void
    {
        $this->attributes['role'] = $role;
    }

    public function getId(): int
    {
        return $this->attributes['id'];
    }

    public function getName(): string
    {
        return $this->attributes['name'];
    }

    public function setName(string $name): void
    {
        $this->attributes['name'] = $name;
    }

    public function getEmail(): string
    {
        return $this->attributes['email'];
    }

    public function setEmail(string $email): void
    {
        $this->attributes['email'] = $email;
    }

    public function getImage(): string
    {
        $image = $this->attributes['image'];

        if (filter_var($image, FILTER_VALIDATE_URL)) {
            return $image;
        }

        return url('storage/'.ltrim($image, '/'));
    }

    public function setImage(string $image): void
    {
        $this->attributes['image'] = $image;
    }

    public function getAddress(): string
    {
        return $this->attributes['address'] ?? '';
    }

    public function setAddress(string $address): void
    {
        $this->attributes['address'] = $address;
    }

    public function getCreditCard(): string
    {
        return $this->attributes['credit_card'] ?? '';
    }

    public function setCreditCard(string $creditCard): void
    {
        $this->attributes['credit_card'] = $creditCard;
    }

    public function getCreatedAt(): string
    {
        return $this->attributes['created_at'];
    }

    public function getUpdatedAt(): string
    {
        return $this->attributes['updated_at'];
    }

    public function favList(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'user_favorites_products', 'user_id', 'product_id');
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = $value;
    }

    public function getPets(): Collection
    {
        return $this->pets()->get();
    }

    public function getFavList(): Collection
    {
        return $this->favList()->get();
    }

    public function getOrders(): Collection
    {
        return $this->orders()->get();
    }

    public static function validate(Request $request): void
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
            'credit_card' => 'nullable|string|size:16',
            'password' => 'nullable|string|min:6',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'pets' => 'nullable|string',
            'favList' => 'nullable|string',
        ],
            [
                'name.required' => __('validation.required', ['attribute' => __('User.name')]),
                'email.required' => __('validation.required', ['attribute' => __('User.email')]),
                'email.email' => __('validation.email', ['attribute' => __('User.email')]),
                'address.required' => __('validation.required', ['attribute' => __('User.address')]),
                'credit_card.size' => __('validation.size', ['attribute' => __('User.credit_card')]),
                'password.min' => __('validation.min.string', ['attribute' => __('User.password'), 'min' => 6]),
                'image.image' => __('validation.image', ['attribute' => __('User.image')]),
                'image.mimes' => __('validation.mimes', ['attribute' => __('User.image'), 'values' => 'jpg, jpeg, png, gif']),
                'image.max' => __('validation.max.file', ['attribute' => __('User.image'), 'max' => 2048]),
            ]
        );
    }

    public function pets(): HasMany
    {
        return $this->hasMany(Pet::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function pet(): HasMany
    {
        return $this->hasMany(Pet::class);
    }
}
