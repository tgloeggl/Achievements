<?
$infobox = array();
$infobox['picture'] = 'infobox/studygroup.jpg';
$infobox['content'] = array(
    array(
        'kategorie' => _("Information"),
        'eintrag'   => array(
            array(
                'text' => _('Du befindest dich in dem Profil eines deiner Freunde. Links siehst den Vergleich eurer Trohpäen'),
                'icon' => 'icons/16/black/info.png'
            ),
        )
    )
);
?>

<?= $this->render_partial('index/_compare_trophys') ?>