<div class="row" style="margin:2% auto;">
    <div class="col-md-4">
    </div>
    <div class="boxy white-bg col-md-8" style="padding:2%;margin:auto">
        <h4 class="blue">
            Oops.  The page you were looking for isn't here.
        </h4>
        
        <div class="alert alert-warning">
          <?php _e('404 - Page Not Found', 'roots'); ?>
        </div>
        
        <p>Please search again:</p>
        <?php get_search_form(); ?>

        <br/><br/>
        <p class="red"><?php _e('It looks like this was the result of either:', 'roots'); ?></p>
        <ul>
          <li><?php _e('a mistyped address', 'roots'); ?></li>
          <li><?php _e('an out-of-date link', 'roots'); ?></li>
        </ul>
        
    </div>
    <br/><br/>
</div>