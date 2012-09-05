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
require_once $this->trails_root . '/models/AchievementsModel.php';
require_once $this->trails_root . '/models/Achievement.php';
require_once $this->trails_root . '/models/Friends.php';


class IndexController extends StudipController {

    // registered Achievements
    static $registered_achievements = array(
        array('Login'),
        array('PictureSilver'),
        array('CreateStudygroup'),
        array('EnterSeminar'),
        array('VisitSchedule'),
        array('BuddyBronze', 'BuddySilver', 'BuddyGold'),
        array('NewsBronze', 'NewsSilver', 'NewsGold'),
        array('ForumBronze','ForumSilver', 'ForumGold'),
        array('CoreGroupGold'),
        array('AssociationGold'),
    );
    
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
        // check for newly received trophys
        if (!$user_id) $user_id = $GLOBALS['user']->id;

        // get already received achievements
        $received = AchievementsModel::getAchievements($user_id);

        foreach (self::$registered_achievements as $achievements) {
            foreach ($achievements as $achievement_id) {
                if (!in_array($achievement_id, $received)) {
                    $counter++;
                    $class_name = 'Achievement' . $achievement_id;
                    if (strpos($achievement_id, 'Silver') !== false) {
                        $picture = 'silver_trophy.png';
                    } else if (strpos($achievement_id, 'Gold') !== false) {
                        $picture = 'gold_trophy.png';
                    } else {
                        $picture = 'bronze_trophy.png';
                    }

                    require_once $this->dispatcher->trails_root . '/achievements/' . $class_name . '.php';

                    if (call_user_func(array($class_name, 'hasMetRequirements'), $user_id)) {
                        AchievementsModel::giveAchievement($achievement_id);
                        $title = call_user_func(array($class_name, 'getTitle'));
                        $this->trophys[] = array(
                            'title'   => $title,
                            'picture' => $this->picturepath .'/'. $picture
                        );
                    }
                    
                    break;
                }
            }
        }
    }

    function achievements_action()
    {
        Navigation::activateItem('/profile/trohpies/index');

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
        foreach (self::$registered_achievements as $achievements) {
            foreach ($achievements as $achievement_id) {
                $class_name = 'Achievement' . $achievement_id;
                require_once $this->dispatcher->trails_root . '/achievements/' . $class_name . '.php';

                if (strpos($achievement_id, 'Silver') !== false) {
                    $picture = 'silver_trophy.png';
                } else if (strpos($achievement_id, 'Gold') !== false) {
                    $picture = 'gold_trophy.png';
                } else {
                    $picture = 'bronze_trophy.png';
                }


                $has_trophy = in_array($achievement_id, $received);                    
                $this->trophys[$has_trophy ? 'full' : 'empty'][] = array(
                    'title'       => call_user_func(array($class_name, 'getTitle')),
                    'description' => call_user_func(array($class_name, 'getDescription')),
                    'progress'    => call_user_func(array($class_name, 'getProgress'), $GLOBALS['user']->id),
                    'received'    => $has_trophy,
                    'picture'     => $picture
                );
            }
        }
    }
    
    function compare_action($compare_with = null) {
        
        Navigation::activateItem('/profile/trohpies/compare');

        $layout = $GLOBALS['template_factory']->open('layouts/base');
        $this->set_layout($layout);

        PageLayout::setTitle('Trophäen meiner Freunde');
        
        if ($compare_with) {
            foreach (array($compare_with, $GLOBALS['user']->id) as $user_id) {
                $received = AchievementsModel::getAchievements($user_id);

                foreach ($received as $achievement_id) {
                    $class_name = 'Achievement' . $achievement_id;
                    require_once $this->dispatcher->trails_root . '/achievements/' . $class_name . '.php';

                    // #TODO: fix AchievementsModel::getAchievements to fetch the type as well

                    if (strpos($achievement_id, 'Silver') !== false) {
                        $picture = 'silver_trophy.png';
                    } else if (strpos($achievement_id, 'Gold') !== false) {
                        $picture = 'gold_trophy.png';
                    } else {
                        $picture = 'bronze_trophy.png';
                    }


                    $this->trophys[$user_id][$achievement_id] = array(
                        'title'       => call_user_func(array($class_name, 'getTitle')),
                        'picture'     => $picture
                    );
                }
            }
        }
        
        foreach ((array)AchievementsModel::getAchievementsForUsers(Friends::get($GLOBALS['user']->id)) as $data) {
            $this->my_friends[$data['user_id']][$data['type']] = $data['trophys'];
        }
        
        $this->all_achievements = self::$registered_achievements;
        $this->compare_with = $compare_with;
    }
}
