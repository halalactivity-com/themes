<?php extract(shortcode_atts(array(
    'title_tab' => '',
    'service_tab' => '',
    'posts_per_page' => '',
  ), $attr));
if (!empty($service_tab)) {
    $service_tab = vc_param_group_parse_atts($service_tab);
    if (count($service_tab) <= 0) {
        $service_tab = '';
    } elseif (count($service_tab) == 1) {
        $service_tab = $service_tab[0]['tab_service'];
    } else {
        $service_tab = $service_tab;
    }
}
$id_location = get_the_ID();
?>
<div class="st-overview-content st_tab_service">
	<div class="st-content-over">
		<div class="st-content">
			<div class="title">
				<h3><?php echo $title_tab; ?></h3>
			</div>
			<div class="st_tab_service">
				<?php if (is_array($service_tab)) {
					echo '<ul class="nav nav-tabs" role="tablist">';
                        $j = 0;
                        foreach ($service_tab as $vtab) {
                            $active_class = ($j == 0) ? 'active' : '';
                            echo '<li role="' . $vtab['tab_service'] . '" class="' . $active_class . '"><a href="#' . $vtab['tab_service'] . '_ccv" aria-controls="' . $vtab['tab_service'] . '" role="tab" data-toggle="tab">' . $vtab['tab_title'] . '</a></li>';
                            $j++;
                        }
                    echo '</ul>';
				}?>
			</div>
		</div>
		<div class="st-tab-service-content">
			<div class="st-loader-ccv">
				<div class="st-loader">
					
				</div>
			</div>
			<?php
				echo '<div class="tab-content">';
                $jj = 0;
                foreach ($service_tab as $vtabcontent) {
                    switch ($vtabcontent['tab_service']) {
                        case 'st_rental':
                            $folder_name = 'rental';
                            break;
                        case 'st_tours':
                            $folder_name = 'tour';
                            break;
                        case 'st_activity':
                            $folder_name = 'activity';
                            break;
                        case 'st_cars':
                            $folder_name = 'car';
                            break;
                        default:
                            $folder_name = 'hotel';
                            break;
                    }
                    $active_class = ($jj == 0) ? 'active' : '';
                    echo '<div role="tabpanel" class="tab-pane ' . $active_class . '" id="' . $vtabcontent['tab_service'] . '_ccv">';
                    
                    
                    echo st()->load_template('layouts/modern/location/elements/content-' . $folder_name . '', '', array('in_tab' => true, 'posts_per_page' => $posts_per_page, 'id_location'=>$id_location));
                    echo '</div>';
                    $jj++;
                }

                 echo '</div>';
			?>
		</div>
	</div>
</div>

