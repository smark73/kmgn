<?php // Summer Promotion 2016 Casino Chip Modal ?>


<div class="modal fade" id="sumPromoModal" tabindex="-1" role="dialog" aria-labelledby="sumPromoModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="sumPromoModalLabel">
                    Enter Here!
                </h4>
            </div>

            <div class="modal-body centered">

                <div class="sumPromoEntryForm">

                    <h1>You Found It! Enter Here</h1>

                    <?php
                        // !!!!!!!!!!!!!!!!!!!!!
                            // NEED GF FORM ID HERE !!!!! (submit via ajax to keep modal open)
                        // !!!!!!!!!!!!!!!!!!!!!
                        if ( live_or_local() === 'live' ){
                            //live production
                            $gf_id = 14;
                        } else {
                            //dev
                            $gf_id = 1;
                        }

                        $gf_shortcode_txt = '[gravityform id="' . $gf_id . '" title="false" description="false" ajax="true"]';

                        echo do_shortcode($gf_shortcode_txt);
                    ?>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>
