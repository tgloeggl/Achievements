<? foreach ($trophys as $type => $list) : ?>
    <? foreach ($list as $trophy) : ?>
    <div style="width: 301px; margin-right: 10px; float: left; <?= ($trophy['received']) ? '' : 'opacity: 0.7;' ?>">
    <div class="gritter-item-wrapper">
        <div class="gritter-top"></div>
        <div class="gritter-item" style="min-height: 100px;">
            <div class="gritter-close" style="display: none;"></div>

            <img class="gritter-image" src="<?= $picturepath ?>/<?= $trophy['picture'] ?>">

            <div class="gritter-with-image">
            <? if ($trophy['received']) : ?>
                <span class="gritter-title"><?= $trophy['title'] ?></span>
                <p><?= $trophy['description'] ?></p>

            <? else : ?>

                <p style="color: #AAAAAA"><?= $trophy['description'] ?></p>
                <? if ($trophy['progress']) : ?>
                <br>
                <p style="color: #AAAAAA"><?= $trophy['progress'] ?></p>
                <? endif ?>
            <? endif ?>

            </div>
            <div style="clear:both"></div>
        </div>

        <div class="gritter-bottom"></div>
    </div>
    </div>
    <? endforeach ?>
<? endforeach ?>