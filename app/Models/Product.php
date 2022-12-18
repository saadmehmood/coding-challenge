<?php

namespace App\Models;

use App\Traits\DiscountTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, DiscountTrait;

    public const CURRENCY = 'EUR';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sku',
        'name',
        'category',
        'price',
    ];

    /**
     * Scope a query to search posts
     */
    public function scopeSearch(Builder $query, ?array $search): Builder
    {
        if (!empty($search['category'])) {
            $query->where('category', 'LIKE', "%{$search['category']}%");
        }
        if (!empty($search['priceLessThan'])) {
            $query->where('price', '<=', "{$search['priceLessThan']}");
        }

        return $query;
    }

    /**
     * @return array
     */
    public function getDiscountedPrice(): array
    {
        $finalPrice = $price = $this->price;
        $discountPercentage = 0;

        foreach ($this->getDiscounts() as $discount) {
            $type = $discount['type'];

            if ($this->{$type} === $discount['value'] && $discount['percentage'] > $discountPercentage) {
                $discountPercentage = $discount['percentage'];
            }
        }

        if ($discountPercentage) {
            $finalPrice = (int) ($price - ($price * ($discountPercentage / 100)));
            $discountPercentage .= '%';
        } else {
            $discountPercentage = null;
        }

        return [
            'original' => $this->price,
            'final' => $finalPrice,
            'discount_percentage' => $discountPercentage,
            'currency' => self::CURRENCY
        ];
    }
}
