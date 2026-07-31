# Legacy Theme Audit

Source audited: cumulative `NVConsult-Theme-v2-Milestone31-50` package supplied by the project owner.

## Inventory

The package contains a complete WordPress theme with 77 non-changelog files plus historical milestone notes. Important areas include:

- Theme templates: `front-page.php`, header/footer, archive/single/page/404.
- Eight page templates for About, Booking, Contact, CV Maker, Jobs Abroad, Legal, Study Visas and Work Visas/Pricing.
- Frontend/admin CSS and JavaScript.
- Homepage editing/builder code.
- Booking helpers and consultation plans.
- Content scaffolds for Countries, Universities, Scholarships, Internships, Study Programs, FAQs, Testimonials and Knowledge Centre.
- Application, document, search, relationship, SEO, accessibility, performance and multilingual scaffolds.

## Findings

1. The visual homepage is substantially more mature than many later milestone modules and must be preserved during refactoring.
2. Durable content models are currently registered from the theme. These should move to `nvconsult-core` so changing themes does not remove platform data behavior.
3. Several milestone 31–50 files are placeholders (for example admin framework, relationships, notifications, SEO, performance and multilingual helpers). They must not be treated as production-complete features.
4. Some relationships are stored as free-form post meta strings. Production relationships should use stable IDs/taxonomies and controlled admin selectors.
5. Application/document handling is only a scaffold and requires authorization, secure upload controls, statuses, audit data and privacy rules before public use.
6. Historical milestone changelog TXT files should not be shipped in the production theme; history belongs in the repository changelog/docs.
7. Theme defaults currently contain substantial business/content configuration. The migration should preserve these defaults while moving reusable domain logic to plugins incrementally.

## Migration strategy

- Import the cumulative theme intact first to avoid visual regressions.
- Introduce `nvconsult-core` alongside it.
- Move one domain at a time from theme `inc/` files to the core plugin while retaining compatibility guards.
- Replace scaffolds with tested implementations instead of merely relocating placeholder code.
- Keep public URLs and post-type slugs stable during migration.
