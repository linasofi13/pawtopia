<?php

namespace App\Services;

use App\Models\User;

class FavoriteService
{
    public function addProductToFavorites(User $user, int $productId): bool
    {
        if (! $user->favList()->where('product_id', $productId)->exists()) {
            $user->favList()->attach($productId);

            return true;
        }

        return false;
    }
}
