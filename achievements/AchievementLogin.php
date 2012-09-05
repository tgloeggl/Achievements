<?php

class AchievementLogin implements Achievement {

    public static function hasMetRequirements($user_id) {
        if ($GLOBALS['user']->id) return true;
        
        return false;
    }

    public static function getProgress($user_id) {
        return false;
    }

    public static function getTitle() {
        return sprintf(_("Du hast dich erfolgreich angemeldet.<br>%sMöchtest du mehr wissen?%s"),
            '<a style="color: lightblue" href="'. PluginEngine::getLink('achievements/index/achievements') .'">',
            '</a>');
    }

    public static function getDescription() {
        return _('Diese Trophäe erhälst du beim ersten Einloggen.');
    }
}
