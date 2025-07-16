<?php

use App\Business\Entities\Taxes;
use App\Business\Services\ProductService;

test('Calcula precion Iva', function () {
    $price = 100;

    $service = new ProductService;

    $result = $service->calculateIVA($price);

    expect($result)->toBe($price * (1 + Taxes::IVA));
});
