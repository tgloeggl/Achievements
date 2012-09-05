<?php

class AchievementNewsBronze implements Achievement {

    public static function hasMetRequirements($user_id) {
        $stmt = DBManager::get()->prepare("SELECT COUNT(*) FROM news
            WHERE user_id = ?"); 
        $stmt->execute(array($user_id));
        
        return $stmt->fetchColumn() > 0;
    }
    
    public static function getProgress($user_id) {
        return sprintf(_("Du hast bisher keine News erstellt."));
    }

    public static function getTitle() {
        return _("Du hast eine  News erstellt.");
    }

    public static function getDescription() {
        return _("Diese Trophäe erhälst du, sobald du eine News erstellt hast.");
    }
}
