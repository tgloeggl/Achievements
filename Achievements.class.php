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

class Achievements extends StudipPlugin implements SystemPlugin
{
    
    /**
     * Initialize a new instance of the plugin.
     */
    function __construct()
    {
        parent::__construct();

        PageLayout::addScript($this->getPluginURL() . '/javascript/application.js');
        # PageLayout::addScript($this->getPluginURL() . '/javascript/jquery.gritter.js');
        PageLayout::addStyleSheet($this->getPluginURL() . '/css/jquery.gritter.css');

        $navigation = new Navigation(_('Trophäen'), PluginEngine::getLink('achievements/index/achievements'));
        
        $sub_nav = new Navigation(_("Meine Trophäen"),
        PluginEngine::getLink('achievements/index/achievements'));
        $navigation->addSubNavigation('index', $sub_nav);

        $sub_nav = new Navigation(_("Trophäen meiner Freunde"),
        PluginEngine::getLink('achievements/index/compare'));
        $navigation->addSubNavigation('compare', $sub_nav);

        Navigation::addItem('/profile/trohpies', $navigation);
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
}
