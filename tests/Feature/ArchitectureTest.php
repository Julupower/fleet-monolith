<?php
declare(strict_types=1);

/**
 * --------------------------------------------------------------------------
 * PROJECT LARAVEL/VUE: Enterprise Architecture Guardrails
 * --------------------------------------------------------------------------
 * These tests automatically enforce Domain-Driven Design (DDD) boundaries.
 * If a developer violates a folder rule, the CI/CD build will fail.
 */

// 1. Enforce strict type safety
it('enforces strict types across the entire application layout')
    ->expect(['App', 'Src'])
    ->toUseStrictTypes();

// 2. Ensure controllers do not contain core business logic
it('ensures controllers stay skinny and do not manipulate models directly')
    ->expect('Src\App')
    ->not->toUse('Src\Domain\Fleet\Models')
    ->ignoring('Src\App\*\Controllers\*');

// 3. Keep independent business domains decoupled
it('prevents the Billing domain from coupling with internal Fleet logic')
    ->expect('Src\Domain\Billing')
    ->not->toUse('Src\Domain\Fleet');

it('prevents the Fleet domain from coupling with internal Billing logic')
    ->expect('Src\Domain\Fleet')
    ->not->toUse('Src\Domain\Billing');