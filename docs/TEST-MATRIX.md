# NVConsult V1 Test Matrix

Use dummy data on staging. Do not test with real passports or applicant identity documents.

| Area | Scenario | Expected |
|---|---|---|
| Public intake | Valid job application | Private application created, status new, valid target linked |
| Public intake | Invalid target/type pair | HTTP 400, no application created |
| Public intake | Repeated submissions | Rate limit eventually returns HTTP 429 |
| Ownership | Applicant A opens own case | Allowed |
| Ownership | Applicant A opens applicant B case | Denied |
| Tracking | Correct tracking token | Limited case status returned |
| Tracking | Wrong token | Denied |
| Documents | PDF/JPG/PNG <= 8MB | Upload succeeds |
| Documents | Executable/oversized file | Rejected |
| Documents | Applicant A downloads own file | Allowed |
| Documents | Applicant A downloads B file | Denied |
| Staff | Consultant assignment | Ownership/history updated |
| Staff | Handoff | New consultant notified and reason audited |
| Staff | Internal note | Staff-only; absent from applicant activity |
| Follow-up | Snooze 1/3/7 days | Date changes and audit event created |
| Follow-up | Complete | Follow-up removed or next date set |
| Deadline | Overdue | Dashboard priority and reminder generated |
| Messaging | Applicant/staff exchange | Only case owner and authorized staff can read |
| CRM | Lead progression | Stage and next action persist |
| Partner CRM | Follow-up due | Reminder generated once per day |
| Opportunities | Job/program/scholarship/internship target | Application target validation matches type |
| AI | Unauthorized user requests summary | Denied |
| AI | Missing key | HTTP 503 with safe message |
| AI | Authorized staff summary | Summary returned and audit event created |
| Privacy | Erasure request | Supported direct identifiers removed; retention warning returned |
| Integrity | Broken attachment/relationship | Appears in Data Integrity screen |
| Audit | Export case audit | CSV downloads only for authorized staff |
| CI | PHP lint | All plugin PHP files pass |
| Secrets | OpenAI key pattern committed | CI fails |

## Release gates

1. Zero PHP syntax errors.
2. Zero known cross-applicant access failures.
3. No public access to protected documents.
4. No API keys in repository/browser output.
5. HTTPS and backups enabled on production.
6. Transactional email tested.
7. Privacy notice and retention policy approved for the actual operating jurisdictions.
8. Critical and high-severity bugs closed before V1 tag.
