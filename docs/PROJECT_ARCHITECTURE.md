# Project Architecture

## Target layout

```text
wp-content/
  themes/
    nvconsult/
  plugins/
    nvconsult-core/
    nvconsult-booking/
    nvconsult-student-portal/
    nvconsult-employer-portal/
    nvconsult-jobs/
    nvconsult-ai/
docs/
```

## Boundaries

### Theme
Public presentation: header/footer, templates, components, assets and visual behavior.

### nvconsult-core
Shared domain layer: CPTs, taxonomies, capabilities, relationships, common admin components, shared REST/AJAX infrastructure and platform settings.

### Feature plugins
Large workflows with independent lifecycle or permissions live separately: booking, portals, jobs/recruitment, CRM and AI.

## Data principles
- Prefer WordPress-native entities where they fit.
- Store relationships by immutable IDs.
- Avoid duplicating the same field in multiple modules.
- Introduce custom tables only for transactional/high-volume data that post meta cannot serve efficiently.

## Integration principles
- Modules communicate through documented WordPress actions/filters and service interfaces.
- External providers are wrapped behind adapters.
- API/provider credentials are never exposed client-side.

## Release workflow
- `main`: stable source of truth.
- Feature/refactor branches: active work.
- Semantic versions for deployable releases.
- Changelog updated for meaningful releases.
