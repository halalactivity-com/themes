<?php

    /**

     * Created by PhpStorm.

     * User: Administrator

     * Date: 20-11-2018

     * Time: 9:18 AM

     * Since: 1.0.0

     * Updated: 1.0.0

     */ ?>

<div class="form-wrapper">

    <div class="row">

        <div class="col-xs-12 col-md-8">

            <div class="row">
        
                <div class="col-xs-12 col-sm-6">

                    <div class="form-group">

                        <input type="text" class="form-control"

                               name="author"

                               placeholder="Name">

                    </div>

                </div>

                <div class="col-xs-12 col-sm-6">

                    <div class="form-group">

                        <input type="email" class="form-control"

                               name="email"

                               placeholder="Email">

                    </div>

                </div>

                <div class="col-xs-12">

                    <div class="form-group">

                        <input type="text" class="form-control"

                               name="comment_title"

                               placeholder="Title">

                    </div>

                </div>

                <div class="col-xs-12">

                    <div class="form-group">

                        <textarea name="comment_text"

                                  class="form-control has-matchHeight"

                                  placeholder="Content"></textarea>

                    </div>

                </div>

            </div>

        </div>

         <div class="col-xs-12 col-md-4">

            <div class="row">
                
                <div class="col-xs-12">
                            
                    <div class="form-group review-items has-matchHeight">

                        <?php

                            $stats = STReview::get_review_stats( get_the_ID() );

                            if ( !empty( $stats ) ) {

                                foreach ( $stats as $stat ) {

                                    ?>

                                    <div class="item">

                                        <label><?php echo $stat[ 'title' ]; ?></label>

                                        <input class="st_review_stats" type="hidden"

                                               name="st_review_stats[<?php echo trim( $stat[ 'title' ] ); ?>]">

                                        <div class="rates">

                                            <?php

                                                for ( $i = 1; $i <= 5; $i++ ) {

                                                    echo '<i class="fa fa-star"></i>';

                                                }

                                            ?>

                                        </div>

                                    </div>

                                    <?php

                                }

                            }

                        ?>

                    </div>
                </div>

                <div class="col-xs-12">                    
                    <div class="text-center">
                    	<?php $post_id = get_the_ID(); ?>
                        <input type="hidden" id="comment_text_post_ID" name="comment_post_ID"
                               value="<?php echo $post_id; ?>">
                        <input type="hidden" id="comment_parent" name="comment_parent" value="0">
                        <input id="submit" type="submit" name="submit"
                               class="btn btn-green upper font-medium"
                               value="<?php echo __('Leave a Review', ST_TEXTDOMAIN) ?>">
                    </div>
                </div>

            </div>


        </div>

    </div>

</div>

