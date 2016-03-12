<?php

class AchievementForumGold implements Achievement {

    public static function hasMetRequirements($user_id) {
        $stmt = DBManager::get()->prepare("SELECT COUNT(*) FROM forum_entries
            WHERE user_id = ?");
        $stmt->execute(array($user_id));

        return $stmt->fetchColumn() > 50;
    }

    public static function getProgress($user_id) {
        $stmt = DBManager::get()->prepare("SELECT COUNT(*) FROM forum_entries
            WHERE user_id = ?");
        $stmt->execute(array($user_id));

        return sprintf(_("Du hast bisher %s Forums-Beitr�ge erstellt."), $stmt->fetchColumn());
    }

    public static function getTitle() {
        return _("Du hast 50 Forums-Beitr�ge verfasst.");
    }

    public static function getDescription() {
        return _("Diese Troph�e erh�lst du, sobald du 50 Beitr�ge in Foren verfasst hast.");
    }
}
