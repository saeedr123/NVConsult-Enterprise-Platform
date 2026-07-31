# NVConsult V1 Integration Test Matrix

Use staging and dummy identities only. Do not test with real passport or applicant data.

| Area | Scenario | Expected result |
|---|---|---|
| Public applications | Submit valid job/program/scholarship/internship application | Private application created with correct type/target and tracking token |
| Public applications | Repeat same email + opportunity within 24h | Duplicate rejected with HTTP 409 |
| Public applications | Invalid target/type pairing | Rejected with HTTP 400 |
| Authentication | Applicant A requests Applicant B case | Access denied |
| Authentication | Consultant requests assigned/unassigned case | Access follows staff capability |
| Documents | Applicant uploads PDF/JPG/PNG <=8MB | Private document record created |
| Documents | Upload executable/oversized file | Rejected |
| Documents | Applicant A downloads Applicant B document | Access denied |
| Workflow | Change status | History entry and applicant notification created |
| Workflow | Assign/reassign consultant | Ownership/audit trail updated |
| Follow-ups | Complete/snooze follow-up | Planner queue updates and history retained |
| Deadlines | Overdue deadline daily job | Staff reminder sent once per day/event |
| Collaboration | Add internal note | Visible to staff, not applicant |
| Collaboration | @mention staff | Mention notification sent |
| CRM | Create lead and move pipeline stage | Stage persists and list reflects change |
| Partner CRM | Set partner follow-up | Daily reminder fires when due |
| Opportunities | Published job/program/scholarship/internship | Public REST/archive available and valid application target |
| Reporting | Seed mixed case statuses | KPI totals match source records |
| AI | Unauthorized user calls summary | Access denied |
| AI | Authorized staff with no API key | Clear 503 configuration response |
| AI | Authorized staff with configured API | Summary contains only grounded case information; audit event added |
| Privacy | Run erasure for applicant | Supported direct identifiers removed; retention warning returned |
| Integrity | Delete referenced attachment in staging | Data Integrity screen flags broken document |
| Health | Disable a required environment setting | Platform Health marks it Needs attention |
| CI | Push PHP syntax error to test branch | PHP Quality workflow fails |

## Release gate

V1 must not be tagged until all critical authentication, document isolation, upload validation, application creation, status workflow and privacy tests pass. Medium-severity UX/reporting defects may be documented for a patch release; security or cross-user data-access defects are blockers.
