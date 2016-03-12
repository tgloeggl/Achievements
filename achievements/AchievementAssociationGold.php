<?php
/**
 * AchievementAssocationGold.php - Members of the Stud.IP e.V. get this Achievement
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License as
 * published by the Free Software Foundation; either version 2 of
 * the License, or (at your option) any later version.
 *
 * @author      Jan-Hendrik Willms <tleilax+studip@gmail.com>
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GPL version 2
 * @category    Stud.IP
 */

class AchievementAssociationGold implements Achievement {

    public static function hasMetRequirements($user_id) {
        $stmt = DBManager::get()->prepare("SELECT COUNT(*)
            FROM seminar_user
            WHERE seminar_id = 'a9fdca48b9a972fbb12408afdc17c9d5'
                AND user_id = ?");
        $stmt->execute(array($user_id));

        return $stmt->fetchColumn() > 0;
    }

    public static function getProgress($user_id) {
        return _('Leider bist du kein Stud.IP e.V. Mitglied.');
    }

    public static function getTitle() {
        return _("Du bist ein Stud.IP e.V. Mitglied.");
    }

    public static function getDescription() {
        return _('Diese Trophäe erhalten nur Stud.IP e.V. Mitglieder.');
    }

    public static function getCustomImage() {
        return 'gold_medal.png';
    }
}
