// <script>
STUDIP.Achievements = {
    showAchievement: function(title, image) {
        var unique_id = jQuery.gritter.add({
            title: 'Neue Trophäe erhalten!',
            sticky: true,
            image: '<?= $picturepath ?>/' + image,
            text: title,
            time: ''
        });

        setTimeout(function(){
            $.gritter.remove(unique_id, {
                fade: true,
                speed: 'slow'
            });

        }, 10000)
    }
}

jQuery(document).ready(function(){
    if (!jQuery.gritter) {
        jQuery('body').append('<script src="' + STUDIP.URLHelper.getURL('plugins_packages/tgloeggl/Achievements/javascript/jquery.gritter.js') + '"></script>');
    }

    jQuery.ajax({
        url: STUDIP.URLHelper.getURL('plugins.php/achievements/index'),
            success: function(data) {
                jQuery('body').append(data);
            }
    });
});
// </script>
