<?php
if (!defined('ABSPATH')) { exit; }

final class NVConsult_Core_Capabilities {
    public const MANAGE_PLATFORM = 'nvconsult_manage_platform';
    public const MANAGE_APPLICATIONS = 'nvconsult_manage_applications';
    public const MANAGE_RECRUITMENT = 'nvconsult_manage_recruitment';

    public static function activate(): void {
        $administrator = get_role('administrator');
        if ($administrator) {
            foreach (self::staff_caps() as $cap) {
                $administrator->add_cap($cap);
            }
        }

        add_role('nvconsult_consultant', 'NVConsult Consultant', [
            'read' => true,
            self::MANAGE_APPLICATIONS => true,
        ]);

        add_role('nvconsult_employer', 'NVConsult Employer', ['read' => true]);
        add_role('nvconsult_agent', 'NVConsult Agent', ['read' => true]);
        add_role('nvconsult_applicant', 'NVConsult Applicant', ['read' => true]);
    }

    public static function deactivate(): void {
        // Roles are intentionally retained to avoid removing access/data associations on deactivation.
    }

    private static function staff_caps(): array {
        return [self::MANAGE_PLATFORM, self::MANAGE_APPLICATIONS, self::MANAGE_RECRUITMENT];
    }
}
