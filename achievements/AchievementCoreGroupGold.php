<?php

class AchievementCoreGroupGold implements Achievement {

    public static function hasMetRequirements($user_id) {           
        $stmt = DBManager::get()->prepare("SELECT COUNT(*)
            FROM seminar_user 
            WHERE seminar_id = 'a75f2b4b9d612e70255ba4b96fa79c9e'
                AND user_id = ?");
        $stmt->execute(array($user_id));
        
        return $stmt->fetchColumn() > 0;
    }

    public static function getProgress($user_id) {
        return _('Leider bist du kein CoreGroup-Mitglied.');
    }

    public static function getTitle() {
        return _("Du bist ein CoreGroup-Mitglied.");
    }

    public static function getDescription() {
        return _('Diese Trophäe erhalten nur CoreGroup-Mitglieder.');
    }
}
