<? if (!empty($trophys)) : ?>
<script>
    <? foreach ($trophys as $data) : ?>
        STUDIP.Achievements.showAchievement('<?= utf8_encode($data['title']) ?>', '<?= $data['picture'] ?>');
    <? endforeach ?>
</script>
<? endif ?>