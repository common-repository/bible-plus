<div class="wrap">
    <h1><?php _e('Bible Plus+ | Proverbs For the Day', 'jwplgbbp'); ?></h1>

    <form method="post">
        <p>
            <button type="submit" name="jwplgbbp-vod-save" class="button button-primary"><?php _e('Save Verses'); ?></button>
        </p>
        <table class="wp-list-table widefat fixed striped">

            <tr>
                <thead>
                    <td style="width:10%"><?php _e('Day', 'jwplgbbp'); ?></th>
    		        <td style="width:10%"><?php _e('Chapter', 'jwplgbbp'); ?></th>
    		        <th style=""><?php _e('Verse Number', 'jwplgbbp'); ?></th>
    		    </thead>
    		</tr>
    		<tbody>
            <?php foreach($this->_vods as $day=>$verse) : ?>
                <tr>
                    <td style="width:10%"><?php _e('Day '.$day, 'jwplgbbp'); ?></td>
                    <td style="width:10%"><?php _e('Chapter '.$day, 'jwplgbbp'); ?></td>
                    <td style="">
                        <?php _e('Verse# ', 'jwplgbbp'); ?>
                        <input type="number" name="jwplgbbp-vod[<?php echo $day; ?>]" value="<?php echo $verse; ?>">
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <p>
            <button type="submit" name="jwplgbbp-vod-save" class="button button-primary"><?php _e('Save Verses'); ?></button>
        </p>
    </form>
    <?php include jwplgbbp_fcreate_path(JWPLGBBP_PATH.'assets/html/admin-footer.html.php'); ?> 
</div>
