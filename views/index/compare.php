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

            array(
                'text' => sprintf(_('Du hast %s XP!'), $experience[$user_id] ),
                'icon' => 'icons/16/black/info.png'
            )
        )
    )
);
?>

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
                <? foreach ($types as $type) : ?>
                    <? if ($friend_trophys[$type]) : ?>
                    <img class="small-trophy" src="<?= $picturepath ?>/<?= $type ?>.png">:
                    <?= $friend_trophys[$type] | '0' ?>
                    <? endif ?>
                <? endforeach ?>
            </p>

            <p>
                XP: <?= $this->experience[$user_id] ?>
            </p>
        </div>
    </div>
    <div class="gritter-bottom"></div>
</div>
</a>
<? endforeach ?>

<br style="clear: both">
<br>

<?= $this->render_partial('index/_compare_trophys') ?>
