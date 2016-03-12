<? if (!empty($trophys)) : ?>
<script>
    <? foreach ($trophys as $data) : ?>
        STUDIP.Achievements.showAchievement('<?= $data['title'] ?>', '<?= $data['picture'] ?>');
    <? endforeach ?>
</script>
<? endif ?>
