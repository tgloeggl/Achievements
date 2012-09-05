<?php

class AchievementCreateStudygroup implements Achievement {

    public static function hasMetRequirements($user_id) {
        $status = studygroup_sem_types();
        
        $stmt = DBManager::get()->prepare("SELECT COUNT(*)
            FROM seminare 
            LEFT JOIN seminar_user USING (seminar_id)
            WHERE seminare.status IN ('" . implode("','", $status) . "')
                AND user_id = ?");
        $stmt->execute(array($user_id));
        
        return $stmt->fetchColumn();
    }

    public static function getProgress($user_id) {
        return sprintf(_('Du hast bisher %s Studiengruppen erstellt.'),
            self::hasMetRequirements($user_id));
    }

    public static function getTitle() {
        return _("Du hast eine Studiengruppe erstellt.");
    }

    public static function getDescription() {
        return _('Diese Trophäe erhälst du, sobald du das erste Mal '
            . 'eine Studiengruppe erstellt hast.');
    }
}
