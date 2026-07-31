# NVConsult Platform Release Checklist

## Environment
- WordPress 6.4+ and PHP 8.0+
- HTTPS enforced
- Pretty permalinks enabled
- Upload directory writable and protected
- WP-Cron working, or replace with a real server cron

## Secrets and AI
- Set `OPENAI_API_KEY` as a server environment variable or secret-manager value
- Never store the API key in WordPress content, JavaScript, browser storage, screenshots, or Git
- Use a dedicated OpenAI project/key for this platform and restrict permissions where available
- Configure API spend alerts/limits and rotate keys periodically
- Consider IP allowlisting when production hosting has stable outbound IP addresses

## WordPress security
- Use least-privilege staff accounts
- Enable MFA for administrator accounts
- Confirm REST endpoints reject unauthorized users
- Test document downloads as applicant A, applicant B, consultant and anonymous visitor
- Back up database and uploads before upgrades

## Privacy / GDPR
- Publish privacy notice and retention periods
- Define lawful basis for applicant, recruitment and education data
- Minimize passport/identity data collection
- Document third-party processors and international transfers
- Test WordPress personal-data erasure/export workflows
- Establish deletion/retention policy for rejected/closed cases

## Functional acceptance
- Lead -> application conversion
- Applicant registration/login
- Application creation and assignment
- Document request/upload/review/replacement
- Applicant/staff messaging and notifications
- Follow-up complete/snooze/deadline escalation
- Internal notes and ownership hand-off
- Jobs/study/scholarship/internship opportunity paths
- CRM and partner follow-ups
- Reports/KPIs
- AI case summary with authorized staff only

## Pre-launch
- Run GitHub Actions PHP Quality workflow
- Resolve all PHP lint failures
- Test on staging with representative dummy data
- Review email deliverability and configure transactional SMTP/provider
- Confirm backups and restore procedure
- Review logs for PHP warnings/notices
- Perform role/permission regression testing
- Only then tag a V1 release
