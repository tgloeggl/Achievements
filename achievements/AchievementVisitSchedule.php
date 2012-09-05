<?php

class AchievementVisitSchedule implements Achievement {

    public static function hasMetRequirements($user_id) {
        return strpos($_SERVER['HTTP_REFERER'], 'dispatch.php/calendar/schedule') !== false;
    }

    public static function getProgress($user_id) {
        return _('Tipp: Klick in der Hauptnavigation auf Planer, dann auf Stundenplan.');
    }

    public static function getTitle() {
        return _("Du hast dir deinen Stundenplan angesehen.");
    }

    public static function getDescription() {
        return _('Diese Trophäe erhälst du, sobald du dir das erste Mal '
            . 'deinen Stundenplan ansiehst.');
    }
}
