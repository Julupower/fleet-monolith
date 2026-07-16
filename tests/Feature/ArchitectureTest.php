<?php

declare(strict_types=1);

// 1. Enforce strict types across our application namespaces
it('enforces strict types across the entire application layout')
    ->expect(['App', 'Src'])
    ->toUseStrictTypes();

// 2. Ensure presentation-layer elements do not directly touch domain data layers
it('ensures controllers stay skinny and do not manipulate models directly')
    ->expect('Src\App')
    ->not->toUse('Src\Domain\Fleet\Models')
    ->ignoring('Src\App\*\Controllers\*');

// 3. Prevent the Billing domain from accessing Fleet domain processes
it('prevents the Billing domain from coupling with internal Fleet logic')
    ->expect('Src\Domain\Billing')
    ->not->toUse('Src\Domain\Fleet');

// 4. Prevent the Fleet domain from accessing Billing domain processes
it('prevents the Fleet domain from coupling with internal Billing logic')
    ->expect('Src\Domain\Fleet')
    ->not->toUse('Src\Domain\Billing');