<?php

class AchievementEnterSeminar implements Achievement {

    public static function hasMetRequirements($user_id) {
        $status = studygroup_sem_types();
        
        $stmt = DBManager::get()->prepare("SELECT COUNT(*)
            FROM seminare 
            LEFT JOIN seminar_user USING (seminar_id)
            WHERE seminare.status NOT IN ('" . implode("','", $status) . "')
                AND user_id = ?");
        $stmt->execute(array($user_id));
        
        return $stmt->fetchColumn();
    }

    public static function getProgress($user_id) {
        return sprintf(_('Du bist bisher in %s Veranstaltungen eingetragen.'),
            self::hasMetRequirements($user_id));
    }

    public static function getTitle() {
        return _("Du hast dich in eine Veranstaltung eingetragen.");
    }

    public static function getDescription() {
        return _('Diese Trophäe erhälst du, sobald du dich in deine '
            . 'erste Veranstaltung eingetragen hast.');
    }
}
