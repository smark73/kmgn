<?php // Summer Promotion 2016 Casino Chip Modal ?>


<div class="modal fade" id="sumPromoModal" tabindex="-1" role="dialog" aria-labelledby="sumPromoModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title black" id="sumPromoModalLabel">
                    Best of Both Worlds
                </h2>
            </div>

            <div class="modal-body centered">

                <div class="sumPromoEntryForm">

                    <h3 class="red">Two Chance Tuesdays</h3>
                    <h3 class="black">Here's your 2nd chance to enter to qualify!</h3>
                    <p style="font-size:1.3em;">You'll be entered in the drawing for the Grand Finale!</p>
                    <p style="font-size:1.3em;">You'll also be entered to win the $77 valued package</p>
                    <p style="font-size:1.3em;">at Twin Arrows Casino!</p>

                    <?php
                        // !!!!!!!!!!!!!!!!!!!!!
                            // NEED GF FORM ID HERE !!!!! (submit via ajax to keep modal open)
                        // !!!!!!!!!!!!!!!!!!!!!
                        if ( live_or_local() === 'live' ){
                            //live production
                            $gf_id = 7;
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
