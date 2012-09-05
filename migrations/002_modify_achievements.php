<?php

class ModifyAchievements extends Migration {
    function up() {
        DBManager::get()->exec("
            ALTER TABLE `achievements` CHANGE `type` `type` VARCHAR( 60 ) NOT NULL 
        ");
        
        DBManager::get()->exec("UPDATE achievements
            SET type = 'bronze_trophy'
            WHERE type = 'bronze'
        ");

        DBManager::get()->exec("UPDATE achievements
            SET type = 'silver_trophy'
            WHERE type = 'silver'
        ");
        
        DBManager::get()->exec("UPDATE achievements
            SET type = 'gold_trophy'
            WHERE type = 'gold'
        ");
    }
    
    function down() {
    }
}