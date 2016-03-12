<?php

/*
 * Copyright (C) 2011 - Till Glöggler     <tgloeggl@uos.de>
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License as
 * published by the Free Software Foundation; either version 2 of
 * the License, or (at your option) any later version.
 */


/**
 * @author    tgloeggl@uos.de
 * @copyright (c) Authors
 */

require_once 'app/controllers/studip_controller.php';

class IndexController extends StudipController {

    function before_filter(&$action, &$args)
    {
        parent::before_filter($action, $args);

        if ($GLOBALS['CANONICAL_RELATIVE_PATH_STUDIP'] && $GLOBALS['CANONICAL_RELATIVE_PATH_STUDIP'] != '/') {
            $this->picturepath = $GLOBALS['CANONICAL_RELATIVE_PATH_STUDIP'] .'/'. $this->dispatcher->trails_root . '/images';
        } else {
            $this->picturepath = '/'. $this->dispatcher->trails_root . '/images';
        }
    }

    function index_action($user_id = null)
    {
        $this->set_layout(null);
        // check for newly received trophys
        if (!$user_id) $user_id = $GLOBALS['user']->id;

        // get already received achievements
        $received = AchievementsModel::getAchievements($user_id);

        foreach (Achievements::$registered_achievements as $achievements) {
            foreach ($achievements as $achievement_id) {
                if (!$received[$achievement_id]) {
                    $counter++;
                    $class_name = 'Achievement' . $achievement_id;

                    if (call_user_func(array($class_name, 'hasMetRequirements'), $user_id)) {
                        AchievementsModel::giveAchievement($achievement_id, $user_id);
                        $title = call_user_func(array($class_name, 'getTitle'));
                        $this->trophys[] = array(
                            'title'   => $title,
                            'picture' => AchievementsModel::getImage($class_name)
                        );
                    }

                    break;
                }
            }
        }
    }

    function achievements_action()
    {

        Navigation::activateItem('/profile/trophies/index');

        $layout = $GLOBALS['template_factory']->open('layouts/base_without_infobox');
        $this->set_layout($layout);

        PageLayout::setTitle('Meine Trophäen');

        // get already received achievements
        $received = AchievementsModel::getAchievements();

        $this->trophys = array(
            'full'  => array(),
            'empty' => array()
        );

        // get all possible achievements
        foreach (AchievementsModel::getAllAchievements() as $achievements) {
            foreach ($achievements as $achievement_id) {
                $class_name = 'Achievement' . $achievement_id;

                $has_trophy = $received[$achievement_id];
                $this->trophys[$has_trophy ? 'full' : 'empty'][] = array(
                    'title'       => call_user_func(array($class_name, 'getTitle')),
                    'description' => call_user_func(array($class_name, 'getDescription')),
                    'progress'    => call_user_func(array($class_name, 'getProgress'), $GLOBALS['user']->id),
                    'received'    => $has_trophy,
                    'picture'     => AchievementsModel::getImage($class_name)
                );
            }
        }
    }

    function compare_action($compare_with = null) {

        Navigation::activateItem('/profile/trophies/compare');

        $layout = $GLOBALS['template_factory']->open('layouts/base');
        $this->set_layout($layout);
        $this->compare_with = $compare_with;
        $this->experience = array();

        PageLayout::setTitle('Trophäen meiner Freunde');

        foreach ((array)AchievementsModel::getAchievementsForUsers(Friends::get($GLOBALS['user']->id)) as $data) {
            $this->my_friends[$data['user_id']][$data['type']] = $data['trophys'];
            $xp = 0;

            switch ($data['type']) {
                case 'bronze_trophy': $xp = 10;break;
                case 'silver_trophy': $xp = 50;break;
                case 'gold_trophy': $xp = 100;break;
                case 'bronze_medal':  $xp = 200;break;
                case 'gold_medal':  $xp = 1000;break;
            }


            $this->experience[$data['user_id']] += $xp;
        }

        foreach (array($this->compare_with, $GLOBALS['user']->id) as $user_id) {
            $this->achievements[$user_id] = AchievementsModel::getAchievements($user_id);
        }

        foreach ($this->achievements[$GLOBALS['user']->id] as $type) {
            $xp = 0;

            switch ($type) {
                case 'bronze_trophy': $xp = 10;break;
                case 'silver_trophy': $xp = 50;break;
                case 'gold_trophy': $xp = 100;break;
                case 'bronze_medal':  $xp = 200;break;
                case 'gold_medal':  $xp = 1000;break;
            }

            $this->experience[$GLOBALS['user']->id] += $xp;
        }

        $this->all_achievements = AchievementsModel::getAllAchievements();
        $this->types = AchievementsModel::getAllTypes();
        $this->user_id = $GLOBALS['user']->id;
    }

    function single_compare_action()
    {
        Navigation::activateItem('/profile/trophies');

        $layout = $GLOBALS['template_factory']->open('layouts/base');
        $this->set_layout($layout);

        PageLayout::setTitle('Trophäenvergleich');

        $this->compare_with = get_userid(Request::get('username'));

        foreach ((array)AchievementsModel::getAchievementsForUsers(Friends::get($GLOBALS['user']->id)) as $data) {
            $this->my_friends[$data['user_id']][$data['type']] = $data['trophys'];
        }

        foreach (array($this->compare_with, $GLOBALS['user']->id) as $user_id) {
            $achievements[$user_id] = AchievementsModel::getAchievements($user_id);
        }

        $this->all_achievements = AchievementsModel::getAllAchievements();
    }

    function js_action()
    {
        $this->set_layout(null);
    }
}
