<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$app = appBook();
$results = $app->app->booking->getAll();
?>
<div id="stats-loading" style="display: none;"><div class="stats-loading-anim"></div></div>
<div class="modal fade" id="confirmDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
 	<div class="modal-dialog" role="document">
	    <div class="modal-content">
	      	<div class="modal-header">
	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        	<h4 class="modal-title" id="myModalLabel"><?php echo __('Supprimer une période', $app->slug) ?></h4>
	      	</div>
	      	<div class="modal-body">
	        <?php echo __("Êtes vous sûr de vouloir supprimer !?") ?>
	      	</div>
	      	<div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('NON', $app->slug) ?></button>
		        <button id="confirm-delete" type="button" class="btn btn-primary" onclick=""><?php echo __('OUI', $app->slug) ?></button>
	      	</div>
	    </div>
  	</div>
</div>
<div class="col-xs-12">
	<div class="pull-left">
		<h4>
			<a href="<?php echo esc_url( site_url( '/rendez-vous/' ) ); ?>" class="btn btn-primary" style="text-decoration:none;"><?php _e('Voir le calendrier des rendez-vous', $app->slug); ?></a>
		</h4>
	</div>
</div>
<div id="booking-list">
	<!-- <div class="page-header row">
		<h2><?php echo __('Liste de tous les rendez-vous', $app->slug); ?></h2>
	</div> -->
	<div class="col-xs-12">
		<table class="table table-striped app-table">
			<thead>
			<tr>
				<th class=""><?php echo __('Date', $app->slug) ?></th>
				<th><?php echo __('Client', $app->slug) ?></th>
				<th><?php echo __('Service', $app->slug) ?></th>
				<th><?php echo __('Employé(e)', $app->slug) ?></th>
				<th class="col-actions"></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($results["all"] as $booking) { ?>
			<tr id="<?php echo $booking->booking_id ?>">
				<td>
				<?php
					$date = explode('-', $booking->date);
					echo date_i18n( 'l j F Y', strtotime( $booking->date) ).' '.__("à", $app->slug).' '.$booking->hour;
				?>
				</td>
				<td><?php echo $booking->firstname.' '.$booking->lastname; ?></td>
				<td><?php echo $app->app->service->getServiceName($booking->service_id) ?></td>
				<td>
				<?php 
					if ($booking->employee_id == 0)
					{
						echo __("Non spécifié(e)", $app->slug);
					}else{
						$employee = $app->app->employee->getSingle($booking->employee_id);
						echo $employee->firstname.' '.$employee->lastname;
					}
				?>
				</td>
				<td>
					<div class="pull-right">
						<a href="<?php echo esc_url( add_query_arg( 'booking', $booking->booking_id, site_url( '/rendez-vous/' ) ) ) ?>" class="btn btn-large btn-default" style="text-decoration: none;">
			    			<span class="glyphicon glyphicon-edit" aria-hidden="true" title="<?php echo __('Détail', $app->slug); ?>"></span>&nbsp;&nbsp;<?php _e("Détail", $app->slug); ?>	    			
			    		</a>
						<button class="btn btn-large btn-danger delete-booking" autocomplete="off" data-toggle="modal" aria-pressed="false" data-id="<?php echo $booking->booking_id ?>" data-target="#confirmDelete">
			    			<span class="glyphicon glyphicon-remove" aria-hidden="true" title="<?php echo __('Supprimer', $app->slug); ?>"></span>
			    		</button>
		    		</div>
				</td>
			</tr>
		<?php } ?>
		</tbody>
		</table>
		<div class="clearfix"></div>
		<nav aria-label="Page navigation" class="pull-right">
		<?php
		$pagination1 = str_replace('page-numbers', 'pagination', $results["page_links"]);
		$pagination = str_replace("<li><span class='pagination current'>", "<li class='active'><span class='pagination current'>", $pagination1);
		echo $pagination; ?>
		</nav>
	</div>
</div>
<input type="hidden" id="booking_id" value="" />
<script type="text/javascript">
	jQuery(document).ready(function(){
		var ajaxUrl = '<?php echo admin_url( 'admin-ajax.php' ); ?>';
		jQuery('body').on('click', '.delete-booking', function(){
			jQuery('#booking_id').val(jQuery(this).data('id'));
		});
		jQuery('body').on('click', '#confirm-delete', function(){
			jQuery('#confirmDelete').modal('hide');
			jQuery('#stats-loading').show();
			var action = '<?php echo appBook()->slug.'_delete_booking' ?>';
			var successText = '<?php echo __("Suppression réussie", $app->slug); ?>';
			var errorText = '<?php echo __("Erreur lors de la suppression!", $app->slug); ?>';
			jQuery.post(
				ajaxUrl,
				{
					'action': action,
					'id': jQuery('#booking_id').val()
				},
				function(response){
					if(response == '1'){
						alert(successText);
					}else{
						alert(errorText);
					}
					jQuery('#'+jQuery('#booking_id').val()).remove();
					jQuery('#booking_id').val('');
					jQuery('#stats-loading').hide();
				}
			);
		});
	});
</script>