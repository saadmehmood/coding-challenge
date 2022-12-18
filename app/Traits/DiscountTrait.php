<?php

namespace App\Traits;

Trait DiscountTrait
{
    private array $discounts = [
        [
            'type' => 'category',
            'value' => 'boots',
            'percentage' => 30
        ],
        [
            'type' => 'sku',
            'value' => '000003',
            'percentage' => 15
        ]
    ];

    /**
     * @return array|array[]
     */
    public function getDiscounts(): array
    {
        return $this->discounts;
    }

}
