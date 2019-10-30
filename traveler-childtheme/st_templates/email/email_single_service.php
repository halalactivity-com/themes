<div class="owner-info st-sent-mail-customer">

    <?php echo st()->load_template( 'layouts/modern/common/loader' ); ?>

    <?php 

        $get_post_type = get_post_type();

        switch ($get_post_type) {

            // case 'st_hotel':

            //         $type_service = __('Hotel',ST_TEXTDOMAIN);

            //     break;

            // case 'hotel_room':

            //         $type_service = __('Hotel Room',ST_TEXTDOMAIN);

            //     break;

            // case 'st_rental':

            //         $type_service = __('Rental',ST_TEXTDOMAIN);

            //     break;

            // case 'rental_room':

            //         $type_service = __('Rental Room',ST_TEXTDOMAIN);

            //     break;

            case 'st_activity':

                    $type_service = __('Activity',ST_TEXTDOMAIN);

                break;

            // case 'st_tours':

            //         $type_service = __('Tours',ST_TEXTDOMAIN);

            //     break;

            // case 'st_cars':

            //         $type_service = __('Cars',ST_TEXTDOMAIN);

            //     break;

            default:

                # code...

                break;

        }

        $author_id = get_post_field( 'post_author', get_the_ID() );

        $email_owl = get_the_author_meta('user_email',$author_id);

    ?>

    <!-- <h4 class="heading"><?php echo __( 'Inquirement', ST_TEXTDOMAIN ) ?></h4> -->

    <div class="media form-st-send-mail">

        <form class="st_send-mail-form" method="GET" action="">

            <input type="hidden" name="type_service" value="<?php echo $type_service;?>">

            <input type="hidden" name="name_service" value="<?php the_title();?>">

            <input type="hidden" name="email_owl" value="<?php echo $email_owl;?>">

            <div class="form-wrapper">

                <div class="row">

                    <div class="col-md-12 col-xs-12">

                        <div class="form-group">

                            <input type="text" required class="form-control" name="name_st" placeholder="<?php echo __('Name *',ST_TEXTDOMAIN);?>">

                        </div>

                        <div class="form-group">

                            <input type="email" required class="form-control" name="email_st" placeholder="<?php echo __('Email *',ST_TEXTDOMAIN);?>">

                        </div>

                        <div class="form-group">

                            <input type="tel" required class="form-control" name="phone_st" placeholder="<?php echo __('Phone',ST_TEXTDOMAIN);?>">

                        </div>

                        <div class="form-group st_note_send_email">

                            <textarea name="content_st" class="form-control" placeholder="<?php echo __('Note',ST_TEXTDOMAIN);?>" style=""></textarea>

                        </div>

                    </div>

                </div>

                <div class="text-center">

                    <input id="submit" type="submit"  name="submit" class="btn btn-primary btn-green upper font-small sent-email-st" value="<?php echo __('Send',ST_TEXTDOMAIN);?>">

                </div>

                <div class="message-wrapper-sendemail mt30"></div>

            </div>

        </form>

    </div>

</div>