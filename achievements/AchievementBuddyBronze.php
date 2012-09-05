<?php
/**
 * AchievementBuddyBronze.php - Achievement for the first buddy
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License as
 * published by the Free Software Foundation; either version 3 of
 * the License, or (at your option) any later version.
 *
 * @author      Till Glöggler <studip@inspace.de>
 * @license     http://www.gnu.org/licenses/gpl-3.0.html GPL version 3
 * @category    Stud.IP
 */
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
