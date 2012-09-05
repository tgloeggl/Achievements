STUDIP.Achievements = {
    showAchievement: function(title, image) {
        var unique_id = jQuery.gritter.add({
            title: 'Neue Trophäe erhalten!',
            sticky: true,
            image: image,
            text: title
        });
    }
    
        // You can have it return a unique id, this can be used to manually remove it later using
        /*
        setTimeout(function(){

            $.gritter.remove(unique_id, {
                fade: true,
                speed: 'slow'
            });

        }, 6000)
        */
}

jQuery(document).ready(function(){
    if (!jQuery.gritter) {
        jQuery('body').append('<script src="' + STUDIP.URLHelper.getURL('plugins_packages/tgloeggl/Achievements/javascript/jquery.gritter.js') + '"></script>');
    }

    // $this->getPluginURL() . '/javascript/jquery.gritter.js
    jQuery.ajax({
        url: STUDIP.URLHelper.getURL('plugins.php/achievements/index'),
            success: function(data){
                jQuery('body').append(data);
            }
    });    
});