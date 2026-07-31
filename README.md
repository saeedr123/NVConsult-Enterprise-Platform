# NVConsult Enterprise Platform

Unified WordPress platform for NVConsult's education, global mobility, recruitment and digital consultation services.

## Architecture

- `wp-content/themes/nvconsult/` — presentation layer and public-site templates.
- `wp-content/plugins/nvconsult-core/` — shared domain models, CPTs, taxonomies, relationships and APIs.
- `wp-content/plugins/` — larger modules such as booking, student/employer portals, jobs, CRM and AI.
- `docs/` — product, architecture and implementation documentation.

## Development principles

1. Git is the source of truth.
2. Business logic belongs in plugins rather than the theme where practical.
3. Features must be manageable from WordPress admin.
4. Public forms/APIs require authorization, validation, sanitization and abuse protection.
5. Secrets and API keys must never be committed to this repository.
6. Changes are cumulative and documented in `CHANGELOG.md`.

## Current status

Platform-base restructuring has started. Earlier WordPress theme milestones will be consolidated here and progressively converted from scaffolds into production-ready modules.
