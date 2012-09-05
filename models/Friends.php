<?php

class Friends {
    static function get($user_id) {
        $stmt = DBManager::get()->prepare("SELECT DISTINCT a.user_id FROM contact a
            LEFT JOIN contact b ON (a.owner_id = b.user_id AND b.buddy = 1)
            WHERE a.owner_id = ? AND a.buddy = 1");
        $stmt->execute(array($user_id));
        
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}
