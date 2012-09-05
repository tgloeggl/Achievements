<?php

class AchievementPictureSilver implements Achievement {

    public static function hasMetRequirements($user_id) {
        return Avatar::getAvatar($user_id)->is_customized();
    }
    
    public static function getProgress($user_id) {
        return sprintf(_("Du hast bisher kein Profilbild hochgeladen."));
    }

    public static function getTitle() {
        return _("Du hast ein Profilbild hochgeladen.");
    }

    public static function getDescription() {
        return _("Diese Trophäe erhälst du, sobald du ein Profilbild hochgeladen hast.");
    }
}
