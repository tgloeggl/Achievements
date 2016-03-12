<?php
/**
 * Achievement.php - Achievement interface
 *
 * Use this interface, if you need an Achievement who checks if the necessary
 * conditions are mt on every page-load.
 *
 * !!USE THE "NotifiableAchievement" INTERFACE WHERE POSSIBLE!!
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

interface Achievement {
    /**
     * Check, if the passed user has meet the requirements
     *
     * @param string $user_id
     *
     * @return boolean
     */
    public static function hasMetRequirements($user_id);

    /**
     * The text used, when the achievement has not been achieved yet. May contain
     * progress information like, "You already did x, but you also need y and z"
     *
     * @param string $user_id
     *
     * @return string
     */
    public static function getProgress($user_id);

    /**
     * The text when the achievement has been achieved
     *
     * @return string
     */
    public static function getTitle();

    /**
     * The description, what to do to get this achievement
     *
     * @return string
     */
    public static function getDescription();
}
