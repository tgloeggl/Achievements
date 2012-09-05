<?php
/**
 * AchievementNewsGold.php - Achievement for news
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License as
 * published by the Free Software Foundation; either version 3 of
 * the License, or (at your option) any later version.
 *
 * @author      Till Glöggler <studip@inspace.de>
 * @license     http://www.gnu.org/licenses/gpl-3.0.html GPL version 3
 * @category    Stud.IP
 */

class AchievementNewsGold implements Achievement {

    public static function hasMetRequirements($user_id) {
        $stmt = DBManager::get()->prepare("SELECT COUNT(*) FROM news
            WHERE user_id = ?"); 
        $stmt->execute(array($user_id));
        
        return $stmt->fetchColumn() >= 50;
    }
    
    public static function getProgress($user_id) {
        $stmt = DBManager::get()->prepare("SELECT COUNT(*) FROM news
            WHERE user_id = ?"); 
        $stmt->execute(array($user_id));
        
        return sprintf(_("Du hast bisher %s News erstellt."), $stmt->fetchColumn());
    }

    public static function getTitle() {
        return _("Du hast 50 News erstellt.");
    }

    public static function getDescription() {
        return _("Diese Trophäe erhälst du, sobald du 50 News erstellt hast.");
    }
    
    public static function newsDidCreate($news_id) {
        if (self::hasMetRequirements($GLOBALS['user']->id)) {
            AchievementsModel::giveAchievement('NewsGold');
            AchievementsModel::showAchievement(self::getTitle(), 'gold_trophy.png');
        }
    }
    
    public static function register() {
        if (!AchievementsModel::hasAchievement('NewsGold')) {
            NotificationCenter::addObserver('AchievementNewsGold', 'newsDidCreate', 'NewsDidCreate');
        }
    }    
}
