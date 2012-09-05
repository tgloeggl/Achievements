<?php
/**
 * AchievementNewsBronze.php - Achievement for news
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

class AchievementNewsBronze implements NotifiableAchievement {

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
    
    public static function newsDidCreate($news_id) {
        if (self::hasMetRequirements($GLOBALS['user']->id)) {
            AchievementsModel::giveAchievement('NewsBronze');
            AchievementsModel::showAchievement(self::getTitle(), 'bronze_trophy.png');
        }
    }
    
    public static function register() {
        if (!AchievementsModel::hasAchievement('NewsBronze')) {
            NotificationCenter::addObserver('AchievementNewsBronze', 'newsDidCreate', 'NewsDidCreate');
        }
    }
}
