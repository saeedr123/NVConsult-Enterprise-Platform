# Master Specification

## Product
NVConsult Enterprise Platform is a WordPress-based education, global-mobility, consultation and recruitment platform.

## Primary domains
- Services and destination countries
- Universities and study programs
- Scholarships and internships
- Jobs and recruitment
- Consultations and booking
- Applications and documents
- Knowledge Centre and FAQs
- Student, employer, agent and consultant experiences
- CRM, automation and AI-assisted workflows

## Roles
- Administrator
- Consultant
- Student / applicant
- Employer
- Agent

Roles must use least-privilege WordPress capabilities. Public registration must never grant staff capabilities.

## Content model
Core entities include Service, Country, University, Study Program, Scholarship, Internship, Job, FAQ, Testimonial, Article, Consultation and Application. Relationships must use stable IDs rather than display-name strings.

## Admin requirements
- CRUD from WordPress admin for all editorial entities.
- Searchable relationship selectors.
- Repeatable structured fields where required.
- Media selection through WordPress media APIs.
- Ordering/featured controls.
- Import/export for high-volume entities such as jobs.

## Frontend requirements
- Responsive and mobile-first.
- Preserve NVConsult brand/design direction.
- Accessible keyboard navigation and semantic markup.
- SEO-friendly canonical URLs and structured metadata.
- Fast server-rendered initial content; progressive enhancement for filters/interactions.

## Security
- Validate and sanitize all input; escape output at context.
- Nonces for browser state-changing actions.
- Capability checks for admin operations.
- Strict file type/size controls for uploads.
- Rate limiting for public and AI endpoints.
- No API keys, passwords or private tokens in Git.

## OpenAI integration
OpenAI calls must be server-side. Credentials are stored outside source control (environment/secret configuration). The browser receives only application responses, never provider credentials. AI endpoints require authentication where appropriate, authorization, rate/cost limits, logging, timeout handling and explicit data-minimization rules.

## Engineering rule
The theme owns presentation. Durable business/domain behavior belongs in plugins so changing the theme does not destroy platform functionality.
