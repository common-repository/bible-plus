jQuery(function($){

    function jwplg_render_verses(atts,tilte)
    {

    }

    function jwplg_render_verses(verses)
    {

    }

    function jwplg_render_template(attrs,index)
    {
        element = '#jwplg-bbp-bible-box-'+index;
        console.log(element);
        console.log(attrs.bible);

        html = '<div class="jwplg-bbp-verse-container-inner">';


        $(element).html(html);
    }

    function jwplg_bbl_render_bible($ele,$index)
    {
        shortcode_atts = {
            "ajax_url"  : $ele.data('ajax-url'),
            "passage"   : $ele.data('passage'),
            "version"   : $ele.data('version'),
            "sepclass"  : $ele.data('sepclass'),
            "vpl"       : $ele.data('vpl'),
            "cnum"      : $ele.data('cnum'),
            "vnum"      : $ele.data('vnum')
        };

        $.ajax({
            url : shortcode_atts.ajax_url,
            type : 'POST',
            data : {
                action : "get_passage",
                jwplg_bbp_passage: shortcode_atts.passage,
                jwplg_bbp_version: shortcode_atts.version
            },
            success: function(response) {
                shortcode_atts.bible = JSON.parse(response);
                jwplg_render_template(shortcode_atts,$index);
                return;
            }
        });
    }

    $(window).load(function(){

        if( $('.jwplg-bbp-verse-contanier-outter') !== null )
        {
            $('.jwplg-bbp-verse-contanier-outter').each( function(index)
            {
                if( $(this).data('ajax') === "on" )
                {
                    $(this).attr('id','jwplg-bbp-bible-box-'+index);
                    jwplg_bbl_render_bible($(this),index);
                }
            } );
        }
    });

});
