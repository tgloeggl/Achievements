<?php
/*
 * Achievements.class.php - Achievements
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License as
 * published by the Free Software Foundation; either version 2 of
 * the License, or (at your option) any later version.
 *
 * @author      Till Glöggler <till.gloeggler@elan-ev.de>
 * @copyright   2011 ELAN e.V. <http://www.elan-ev.de>
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GPL version 2
 * @category    Stud.IP
 */

require_once 'vendor/trails/trails.php';
require_once 'models/NotifiableAchievement.php';
require_once 'models/AchievementsModel.php';
require_once 'models/Achievement.php';
require_once 'models/Friends.php';

class Achievements extends StudipPlugin implements SystemPlugin
{
    // Achievments relying on notifications
    static $notifiable_achievements = array(
        'NewsBronze', 'NewsSilver', 'NewsGold'
    );
    
    // registered Achievements
    static $registered_achievements = array(
        array('Login'),
        array('PictureSilver'),
        array('CreateStudygroup'),
        array('EnterSeminar'),
        array('VisitSchedule'),
        array('LongServiceMedal'),
        array('BuddyBronze', 'BuddySilver', 'BuddyGold'),
        array('ForumBronze','ForumSilver', 'ForumGold'),
        array('CoreGroupGold'),
        array('AssociationGold'),
    );

    /**
     * Initialize a new instance of the plugin.
     */
    function __construct()
    {
        parent::__construct();

        PageLayout::addHeadElement('script', array('src' => PluginEngine::getLink('achievements/index/js')), '');
        # PageLayout::addScript($this->getPluginURL() . '/javascript/jquery.gritter.js');
        PageLayout::addStyleSheet($this->getPluginURL() . '/css/jquery.gritter.css');
        PageLayout::addStyleSheet($this->getPluginURL() . '/css/achievements.css');

        foreach (AchievementsModel::getAllAchievements() as $achievements) {
            foreach ($achievements as $achievement_id) {
                require_once 'achievements/Achievement' . $achievement_id .'.php';
            }
        }
        
        $about_user = Request::get('username');
        $about_user_id = get_userid(Request::get('username'));

        if ($about_user && $about_user_id != $GLOBALS['user']->id) {
            $navigation = new Navigation(_('Trophäen'), PluginEngine::getLink('achievements/index/single_compare'));
            
            if (Friends::are($GLOBALS['user']->id, $about_user_id)) {
                Navigation::addItem('/profile/trophies', $navigation);
            }
        } else {
            $navigation = new Navigation(_('Trophäen'), PluginEngine::getLink('achievements/index/achievements'));
            
            $sub_nav = new Navigation(_("Meine Trophäen"),
            PluginEngine::getLink('achievements/index/achievements'));
            $navigation->addSubNavigation('index', $sub_nav);

            $sub_nav = new Navigation(_("Trophäen meiner Freunde"),
            PluginEngine::getLink('achievements/index/compare'));
            $navigation->addSubNavigation('compare', $sub_nav);
            
            Navigation::addItem('/profile/trophies', $navigation);
        }
        
        self::registerAchievements();
    }

    /**
     * This method dispatches all actions.
     *
     * @param string   part of the dispatch path that was not consumed
     */
    function perform($unconsumed_path)
    {
        $trails_root = $this->getPluginPath();
        $dispatcher = new Trails_Dispatcher($trails_root, PluginEngine::getUrl('achievements/index'), 'index');
        $dispatcher->dispatch($unconsumed_path);

    }
    
    private function registerAchievements()
    {
        foreach (self::$notifiable_achievements as $name) {
            $class_name = 'Achievement' . $name;
            $class_name::register();
        }
    }
}
