<?
$infobox = array();
$infobox['picture'] = 'infobox/studygroup.jpg';
$infobox['content'] = array(
    array(
        'kategorie' => _("Information"),
        'eintrag'   => array(
            array(
                'text' => _('Wähle einen deiner Freunde zum Vergleichen eurer Trophäen.'),
                'icon' => 'icons/16/black/info.png'
            ),
        )
    )
);
?>

<style>
    div.achieve-profile:hover {
        opacity: 0.7;
    }
    
    table.achievement_list thead td {
        font-size: 12pt;
        text-align: center;
        font-weight: bold;
    }
    
    div.compare {
        background-color: red;
        border-radius: 10px;
    }
    
    img.small-trophy {
        height: 1em;
    }
</style>
<? if (!empty($my_friends)) foreach ($my_friends as $user_id => $friend_trophys) : ?>

<a href="<?= PluginEngine::getLink('achievements/index/compare/' . $user_id) ?>">
<div class="achieve-profile gritter-item-wrapper <?= $compare_with == $user_id ? 'compare' : '' ?>" style="width: 301px; margin-right: 10px; float: left;">
    <div class="gritter-top"></div>
    <div class="gritter-item" style="min-height: 50px;">
        <?= Avatar::getAvatar($user_id)->getImageTag(Avatar::MEDIUM, array('class' => 'gritter-image')) ?>
    
        <div class="gritter-with-image">
            <span class="gritter-title"><?= get_username($user_id) ?><span>
            <br>
            <p>
                <? foreach (array('bronze', 'silver', 'gold') as $type) : ?>
                    <img class="small-trophy" src="<?= $picturepath ?>/<?= $type ?>_trophy.png">:
                    <?= $friend_trophys[$type] | '0' ?>
                <? endforeach ?>
            </p>
        </div>
    </div>
    <div class="gritter-bottom"></div>
</div>
</a>
<? endforeach ?>

<br style="clear: both">
<br>

<? if (!empty($trophys)) : ?>
<table class="achievement_list">
    <thead>
        <tr>
            <td>Meine Trophäen</td>
            <td>Trophäen von <?= get_username($compare_with) ?></td>
        </tr>
    </thead>
<? foreach ($all_achievements as $achievements) : ?>
    <? foreach ($achievements as $achievement_id) : ?>
    <? if ($trophys[$GLOBALS['user']->id][$achievement_id] || $trophys[$compare_with][$achievement_id]) : ?>
    <tr>
        <? foreach(array($GLOBALS['user']->id, $compare_with) as $user_id) : ?>
        <? if ($trophys[$user_id][$achievement_id]) : ?>
        <? $trophy = $trophys[$user_id][$achievement_id] ?>
        <td style="padding-right: 15px;">
            <div style="font-size: 12pt; height: 1.3em; overflow: hidden">
                <img class="small-trophy" src="<?= $picturepath ?>/<?= $trophy['picture'] ?>">
                <?= $trophy['title'] ?>
            </div>
        </td>
        <? else : ?>
        <td style="padding-right: 15px; opacity: 0.3">
            <div style="font-size: 12pt; height: 1.3em; overflow: hidden">
                <img class="small-trophy" src="<?= $picturepath ?>/<?= $trophy['picture'] ?>">
                <?= $trophy['title'] ?>
            </div>
        </td>
        <? endif ?>
        <? endforeach ?>
    <? endif ?>
    <? endforeach ?>
<? endforeach ?>
</table>
<? endif ?>