<?php

class AchievementLongServiceMedal implements Achievement {

    public static function hasMetRequirements($user_id) {
        $stmt = DBmanager::get()->prepare("SELECT mkdate FROM user_info
            WHERE user_id = ?");
        $stmt->execute(array($GLOBALS['user']->id));
        
        return $stmt->fetchColumn() < strtotime('-6 month');
    }
    
    public static function getProgress($user_id) {
        $stmt = DBmanager::get()->prepare("SELECT mkdate FROM user_info
            WHERE user_id = ?");
        $stmt->execute(array($GLOBALS['user']->id));
        
        $registered_since = new DateTime();
        $registered_since->setTimestamp($stmt->fetchColumn());
        $today            = new DateTime();
        $diff = $today->diff($registered_since);
        
        return sprintf(_("Du bist nun seit %d Monaten und %d Tagen in Stud.IP registriert."),
            $diff->m, $diff->d);
    }

    public static function getTitle() {
        return _("Du bist nun schon seit über 6 Monaten in Stud.IP registriert!");
    }

    public static function getDescription() {
        return _("Diese Trophäe erhälst du, wenn du seit mindestens 6 Monaten in Stud.IP registriert bist.");
    }
    
    public static function getCustomImage() {
        return 'bronze_medal.png';
    }
}
