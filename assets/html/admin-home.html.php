<div class="wrap">
    <h1><?php _e('Bible Plus+', 'jwplgbbp'); ?></h1>
    <div class="container">
        <h2><?php _e('Thank you for using Bible Plus+' ,'jwplgbbp'); ?></h2>
        <h4>Upgrade to the premium version to remove branding and receive premium phone and email support.</h4>
        <h2><?php _e('How to use!', 'jwplgbbp'); ?></h2>
        <p><?php _e('Go to the DailyProverb menu item to set your Proverb of the day.', 'jwplgbbp'); ?></p>
        <p><?php _e('Place the following shortcodes in your pages, posts and text widgets to add the bible, or daily proverb to your site.', 'jwplgbbp'); ?></p>
        <h3><?php _e('Bible Shortcode', 'jwplgbbp'); ?></h3>
        <code>[bible passage="Jn3:16"]</code>
        <h4><?php _e('Available Attributes', 'jwplgbbp'); ?></h4>
        <ol>
            <li><?php _e('passage (bible passage which to show) : default Jn3:16', 'jwplgbbp'); ?></li>
            <li><?php _e('version (desired version of the bible) : default KJV. Available versions can be found at <a href="https://wordpress.org/plugins/bible-plus/faq" target="_blank">Bible Plus on WordPress</a>.', 'jwplgbbp'); ?></li>
            <li><?php _e('cnum (show chapter number) yes/no : default yes.', 'jwplgbbp'); ?></li>
            <li><?php _e('vnum (show verse number) yes/no : default yes.', 'jwplgbbp'); ?></li>
            <li><?php _e('vpl (show verses 1-verse-per-line) yes/no : default yes.', 'jwplgbbp'); ?></li>
        </ol>

        <h4><?php _e('This Full Example Shortcode Will Produce The Following Result', 'jwplgbbp'); ?></h4>
        <code>[bible passage="gen1:1-2" version="ylt" vnum="no" cnum="no" vpl="no"]</code>
        <h5><?php _e('Result:', 'jwplgbbp'); ?></h5>
        <p>In the beginning of God's preparing the heavens and the earth --the earth hath existed waste and void, and darkness [is] on the face of the deep, and the Spirit of God fluttering on the face of the waters,</p>


        <h3><?php _e('Daily Proverb Shortcode', 'jwplgbbp'); ?></h3>
        <code>[daily-proverb version="ylt"]</code>
        <h4><?php _e('Available Attributes', 'jwplgbbp'); ?></h4>
        <ol>
            <li><?php _e('version (desired version of the daily proverb) : default KJV. Available versions can be found at <a href="https://wordpress.org/plugins/bible-plus/faq" target="_blank">Bible Plus on WordPress</a>.', 'jwplgbbp'); ?></li>
        </ol>
        <?php include jwplgbbp_fcreate_path(JWPLGBBP_PATH.'assets/html/admin-footer.html.php'); ?>
    </div>
</div>
