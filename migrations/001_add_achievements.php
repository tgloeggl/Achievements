<?php

class AddAchievements extends Migration {
    function up() {
        DBManager::get()->exec("
            CREATE TABLE IF NOT EXISTS `achievements` (
                `achievement_id` varchar(60) NOT NULL,
                `user_id` varchar(32) NOT NULL,
                `type` ENUM('bronze', 'silver', 'gold') NOT NULL,
                PRIMARY KEY (`achievement_id`,`user_id`)
            )
        ");
    }
    
    function down() {
        DBManager::get()->exec("DROP TABLE IF EXISTS achievements");
    }
}