<? if (!empty($achievements)) : ?>
<table class="achievement_list">
    <thead>
        <tr>
            <td>Meine Trophäen</td>
            <td>Trophäen von <?= get_username($compare_with) ?></td>
        </tr>
    </thead>
    <tbody>
<? foreach ($all_achievements as $achievement_list) : ?>
    <? foreach ($achievement_list as $achievement_id) : ?>
    <? if ($achievements[$GLOBALS['user']->id][$achievement_id] || $achievements[$compare_with][$achievement_id]) : ?>
    <tr>
        <? foreach(array($GLOBALS['user']->id, $compare_with) as $user_id) : ?>
        <? $class_name = 'Achievement' . $achievement_id ?>
        <td style="padding-right: 15px;<?= $achievements[$user_id][$achievement_id] ? '': 'opacity: 0.3;' ?>">
            <div style="font-size: 12pt; height: 1.3em; overflow: hidden">
                <img class="small-trophy" src="<?= $picturepath ?>/<?= AchievementsModel::getImage($class_name) ?>">
                <?= $class_name::getTitle() ?>
            </div>
        </td>
        <? endforeach ?>
    <? endif ?>
    <? endforeach ?>
<? endforeach ?>
    </tbody>
</table>
<? endif ?>