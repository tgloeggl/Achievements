<?php

class AchievementNewsSilver implements Achievement {

    public static function hasMetRequirements($user_id) {
        $stmt = DBManager::get()->prepare("SELECT COUNT(*) FROM news
            WHERE user_id = ?"); 
        $stmt->execute(array($user_id));
        
        return $stmt->fetchColumn() >= 10;
    }
    
    public static function getProgress($user_id) {
        $stmt = DBManager::get()->prepare("SELECT COUNT(*) FROM news
            WHERE user_id = ?"); 
        $stmt->execute(array($user_id));
        
        return sprintf(_("Du hast bisher %s News erstellt."), $stmt->fetchColumn());
    }

    public static function getTitle() {
        return _("Du hast 10 News erstellt.");
    }

    public static function getDescription() {
        return _("Diese Trophäe erhälst du, sobald du 10 News erstellt hast.");
    }
}
