<?php

class AchievementBuddyBronze implements Achievement {

    public static function hasMetRequirements($user_id) {
        return sizeof(Friends::get($user_id)) > 0;
    }
    
    public static function getProgress($user_id) {
        return sprintf(_("Du hast bisher keinen Buddy hinzugefügt."));
    }

    public static function getTitle() {
        return _("Du hast einen Buddy hinzugefügt.");
    }

    public static function getDescription() {
        return _("Diese Trophäe erhälst du, sobald du einen Buddy hinzugefügt hast.");
    }
}
