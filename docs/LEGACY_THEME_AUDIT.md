# Legacy Theme Audit — 2026-07-31

Source: cumulative `NVConsult-Theme-v2-Milestone31-50` package supplied for consolidation.

## Findings

- The package contains the working WordPress theme shell, public/page templates, assets and homepage settings implementation.
- `functions.php` is 265 lines and directly loads only `inc/phase1-homepage.php`; many later milestone `inc/*.php` files therefore exist as scaffolds but are not wired into runtime.
- `inc/phase1-homepage.php` is 181 lines and contains much of the active dynamic homepage/admin behavior. It must be preserved during migration.
- `front-page.php` is already dynamic for hero content, route tabs, services, consultation plans, premium support, testimonials and the final CTA.
- Several milestone-era modules are only 2–13 lines and are placeholders rather than production implementations (admin framework, applications, documents, notifications, performance, relationships, search, SEO, multilingual and portal helpers).
- The theme currently mixes presentation, setup/migration logic and business behavior. Durable content models belong in `nvconsult-core`; visual templates stay in the theme.
- PHP syntax validation passed across the supplied PHP files in the audit environment.
- Historical `MILESTONE*_CHANGELOG.txt` files should not ship in the production theme; useful history will be summarized in the repository changelog.

## Migration policy

1. Preserve current design and working homepage behavior first.
2. Do not activate scaffold modules merely because their files exist.
3. Move CPT/taxonomy registration and reusable domain logic into `nvconsult-core` incrementally.
4. Keep compatibility adapters while legacy theme functions are replaced.
5. Replace free-text relationships with stable IDs/taxonomies.
6. Keep booking, portals, CRM and AI as feature modules with explicit permissions/security boundaries.

## First implementation

`nvconsult-core` now starts with canonical content-type registration for Services, Countries, Universities, Study Programs, Scholarships, Internships, Jobs, Testimonials, FAQs and Knowledge Centre articles, plus a shared Destination taxonomy. This is intentionally incremental so the legacy theme can be imported and compatibility-tested before duplicate registrations are removed.
