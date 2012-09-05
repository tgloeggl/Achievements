<?php

class AchievementBuddyGold implements Achievement {

    public static function hasMetRequirements($user_id) {
        return sizeof(Friends::get($user_id)) >= 50;
    }
    
    public static function getProgress($user_id) {
        return sprintf(sprintf(_("Du hast momentan %s Buddies."), sizeof(Friends::get($user_id))));
    }

    public static function getTitle() {
        return _("Du hast 50 Buddies hinzugefügt.");
    }

    public static function getDescription() {
        return _("Diese Trophäe erhälst du, sobald du 50 Buddies hinzugefügt hast.");
    }
}
