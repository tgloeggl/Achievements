<?php

class AchievementsModel {
    static function getAchievements($user_id = null) {
        if (!$user_id) $user_id = $GLOBALS['user']->id;

        $stmt = DBManager::get()->prepare("SELECT achievement_id
            FROM achievements
            WHERE user_id = ?");
        $stmt->execute(array($user_id));

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    
    /**
     *
     * @param array $users 
     */
    static function getAchievementsForUsers($users) {
        if (empty($users)) {
            return false;
        }

        $stmt = DBManager::get()->prepare("SELECT user_id, type, COUNT(*) as trophys
            FROM achievements
            WHERE user_id IN (:users)
            GROUP BY user_id, type");
        $stmt->bindParam(':users', $users, StudipPDO::PARAM_ARRAY);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    static function giveAchievement($achievement_id, $user_id = null) {
        if (!$user_id) $user_id = $GLOBALS['user']->id;

    
        if (strpos($achievement_id, 'Silver') !== false) {
            $type = 'silver';
        } else if (strpos($achievement_id, 'Gold') !== false) {
            $type = 'gold';
        } else {
            $type = 'bronze';
        }        
        
        $stmt = DBManager::get()->prepare("REPLACE INTO achievements
            (achievement_id, user_id, type) VALUES (?, ?, ?)");
        $stmt->execute(array($achievement_id, $user_id, $type));
    }

}
