<?php

class Friends {
    static function get($user_id) {
        $stmt = DBManager::get()->prepare("SELECT DISTINCT a.user_id FROM contact a
            LEFT JOIN contact b ON a.owner_id = b.user_id
            WHERE a.owner_id = ?");
        $stmt->execute(array($user_id));

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    static function are($user_id, $buddy_id) {
        $stmt = DBManager::get()->prepare("SELECT DISTINCT a.user_id FROM contact a
            LEFT JOIN contact b ON a.owner_id = b.user_id
            WHERE a.owner_id = ? AND a.user_id = ?");
        $stmt->execute(array($user_id, $buddy_id));

        return $stmt->fetchAll(PDO::FETCH_COLUMN) ? true : false;
    }
}
