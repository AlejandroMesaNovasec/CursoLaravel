<?php

use App\Business\Entities\ConceptEntity;
use App\Business\Entities\SaleEntity;

test('Creación de SaleEntity correctamente', function () {
    $concept1 = new ConceptEntity(quantity: 2, price: 50.0, product_id: 1);
    $concept2 = new ConceptEntity(quantity: 1, price: 30.0, product_id: 2);

    $sale = new SaleEntity(id: 1, email: "test@example.com", sale_date: '2025-01-12 15:01:01', concepts: [$concept1, $concept2]);

    expect($sale->id)->toBe(1)
        ->and($sale->email)->toBe("test@example.com")
        ->and($sale->sale_date)->toBe('2025-01-12 15:01:01')
        ->and($sale->concepts)->toBeArray()
        ->and($sale->concepts)->toHaveCount(2);
});