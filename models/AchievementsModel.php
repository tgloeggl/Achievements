<?php

class AchievementsModel {
    static function getAchievements($user_id = null) {
        if (!$user_id) $user_id = $GLOBALS['user']->id;

        $stmt = DBManager::get()->prepare("SELECT achievement_id, type
            FROM achievements
            WHERE user_id = ?");
        $stmt->execute(array($user_id));

        return $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
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
            GROUP BY user_id, type
            ORDER BY trophys DESC");
        $stmt->bindParam(':users', $users, StudipPDO::PARAM_ARRAY);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    static function giveAchievement($achievement_id, $user_id = null) {
        if (!$user_id) $user_id = $GLOBALS['user']->id;

        $type = str_replace('.png', '', self::getImage('Achievement' . $achievement_id));
        
        var_dump($type);
        
        $stmt = DBManager::get()->prepare("REPLACE INTO achievements
            (achievement_id, user_id, type) VALUES (?, ?, ?)");
        $stmt->execute(array($achievement_id, $user_id, $type));
    }
    
    static function hasAchievement($achievement_id, $user_id = null) {
        static $achievements = array();
        
        if (!$user_id) $user_id = $GLOBALS['user']->id;
        
        if (!$achievements[$user_id]) {
            $stmt = DBManager::get()->prepare("SELECT achievement_id FROM achievements
                WHERE user_id = ?");
            $stmt->execute(array($user_id));
            $achievements[$user_id] = $stmt->fetchAll(PDO::FETCH_COLUMN | PDO::FETCH_ASSOC);
        }
        
        return in_array($achievement_id, $achievements[$user_id]) === false ? false : true;
    }

    static function showAchievement($title, $image)
    {
        ?>
        <script>
        jQuery(document).ready(function() {
            STUDIP.Achievements.showAchievement('<?= utf8_encode($title) ?>', '<?= $image ?>');
        });
        </script>
        <?
    }
    
    static function getImage($class_name)
    {
        $picture = 'bronze_trophy.png';
        
        if (method_exists($class_name, 'getCustomImage')) {
            $picture = $class_name::getCustomImage();
        } else if (strpos($class_name, 'Silver') !== false) {
            $picture = 'silver_trophy.png';
        } else if (strpos($class_name, 'Gold') !== false) {
            $picture = 'gold_trophy.png';
        }

        return $picture;
    }
    
    static function getAllAchievements()
    {
        return array_merge(array(Achievements::$notifiable_achievements), Achievements::$registered_achievements);
    }
    
    static function getAllTypes()
    {
        return array(
            'bronze_trophy', 'silver_trophy', 'gold_trophy',
            'bronze_medal',  'silver_medal',  'gold_medal',
        );

        /*
        $stmt = DBManager::get()->query("SELECT DISTINCT type FROM achievements
            ORDER BY type ASC");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
         * 
         */
    }
}
