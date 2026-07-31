# NVConsult Integration Audit

## Fixed in stabilization pass
- Removed duplicate Scholarship/Internship post-type registration from the runtime loader. These types already belong to `NVConsult_Core_Content_Types`.
- Added explicit activation/deactivation lifecycle for rewrite rules and scheduled follow-up jobs.
- Tightened anonymous application creation rate limits.
- Moved security headers from admin-only execution to WordPress `send_headers`.
- Kept OpenAI credentials server-side only.

## Architecture decisions
- `NVConsult_Core_Content_Types` is the canonical owner of public opportunity post types.
- `NVConsult_Core_Applications` is the canonical owner of applications and opportunity target validation.
- CRM and Partner CRM remain private staff data domains.
- AI features are assistive only; they must not autonomously approve/reject applications or make immigration, legal, admissions, employment or scholarship eligibility decisions.

## Remaining release blockers
1. Run PHP lint/CI on the branch and resolve failures.
2. Staging install/activation test against the target WordPress/PHP versions.
3. Role matrix test for administrator, consultant, employer, agent, applicant and anonymous user.
4. Cross-account authorization test for application, document, message and download endpoints.
5. End-to-end applicant journey test for each opportunity type.
6. Email delivery configuration and bounce/failure handling.
7. Data-retention policy and privacy/export coverage review.
8. Performance test with realistic application/document volumes.
9. UI/mobile accessibility pass.
10. Backup/restore and upgrade rollback test.

## V1 rule
Do not mark this platform production-ready solely because the feature code exists. V1 requires the release blockers above to be tested in a staging environment and critical findings resolved.
