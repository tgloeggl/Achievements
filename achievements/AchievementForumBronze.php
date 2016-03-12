<?php

class AchievementForumBronze implements Achievement {

    public static function hasMetRequirements($user_id) {
        $stmt = DBManager::get()->prepare("SELECT COUNT(*) FROM forum_entries
            WHERE user_id = ?");
        $stmt->execute(array($user_id));

        return $stmt->fetchColumn() > 0;
    }

    public static function getProgress($user_id) {
        return sprintf(_("Du hast bisher keinen Forums-Beitrag erstellt."));
    }

    public static function getTitle() {
        return _("Du hast deinen ersten Forums-Beitrag verfasst.");
    }

    public static function getDescription() {
        return _("Diese Trophäe erhälst du, sobald du einen Beitrag in einem Forum verfasst hast.");
    }
}
