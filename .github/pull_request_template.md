## Description
<!-- Provide a brief summary of the changes introduced by this PR -->
- Implemented the core database migration schemas and Domain Models for the Fleet Management domain.
- Configured automated architectural guardrails and verified strict typing across application domains.

## Type of Change
- [x] New feature (non-breaking change which adds functionality)
- [ ] Bug fix (non-breaking change which fixes an issue)
- [ ] Refactor (non-breaking architectural changes)

## Architectural & Domain Impact
- **Domain:** Fleet Management (`src/Domain/Fleet`)
- **Database:** Added `vehicles` (UUID primary keys) and `telemetry_records` tables.
- **Guardrails:** Ensured strict separation between Application layers and Domain Models via Pest architecture tests.

## Checklist
- [x] My code follows the strict typing guidelines of this project.
- [x] I have performed a self-review of my own code.
- [x] I have written automated Feature tests to verify my changes.
- [x] All new and existing tests passed successfully (`sail test`).
