<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $wpdb;
$app = appBook();

$pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
$limit = 10;
$offset = ( $pagenum - 1 ) * $limit;
$total_all = $wpdb->get_var( "SELECT COUNT(app_id) FROM `".$wpdb->prefix.appBook()->slug."_app`" );
if (isset($_POST["cs"]))
{
	$app_name = $_POST["cs"];
	$all = $wpdb->get_results( 
		"
		SELECT `{$wpdb->prefix}appbook_app`.*, `{$wpdb->prefix}appbook_module`.module_id, `{$wpdb->prefix}appbook_module`.folder, `{$wpdb->prefix}appbook_module`.comments
		FROM `{$wpdb->prefix}appbook_app`
		LEFT JOIN `{$wpdb->prefix}appbook_module`
		ON `{$wpdb->prefix}appbook_module`.app_id = `{$wpdb->prefix}appbook_app`.app_id
		WHERE `{$wpdb->prefix}appbook_app`.app_name LIKE '%$app_name%'
		OR `{$wpdb->prefix}appbook_module`.folder LIKE '%$app_name%'
		ORDER BY `app_id` DESC
		LIMIT {$offset}, {$limit}
		", OBJECT
	);
	$total = $wpdb->num_rows;
}
else
{
	$all = $wpdb->get_results( 
		"
		SELECT `{$wpdb->prefix}appbook_app`.*, `{$wpdb->prefix}appbook_module`.module_id, `{$wpdb->prefix}appbook_module`.folder, `{$wpdb->prefix}appbook_module`.comments
		FROM `{$wpdb->prefix}appbook_app`
		LEFT JOIN `{$wpdb->prefix}appbook_module`
		ON `{$wpdb->prefix}appbook_module`.app_id = `{$wpdb->prefix}appbook_app`.app_id
		ORDER BY `app_id` DESC
		LIMIT {$offset}, {$limit}
		", OBJECT
	);
	$total = $wpdb->num_rows;
}
$num_of_pages = ceil( $total / $limit );
?>
<div id="app-loading" style="display: none;"><div class="app-loading-anim"></div></div>
<div class="wrap">
 	<h1 id="rdv-title">
 		<?php _e('Applications RDV', $app->slug); ?>&nbsp;&nbsp;&nbsp;
 		<button id="regenerate-module" class="page-title-action"><?php _e('Régénérer les modules', $app->slug) ?></button>
 	</h1>
 	<form id="app-search-form" method="post" action="<?php echo admin_url('admin.php?page=app-rdv'); ?>">
 	<p class="search-box">
	<label class="screen-reader-text" for="app-search-input">Rechercher dans les pages:</label>
	<input type="search" id="app-search-input" name="cs" value="">
	<input type="submit" id="app-search-submit" class="button" value="Rechercher une société">
	</p>
	</form>
	<?php $page_links = paginate_links( array(
		    'base' => add_query_arg( 'pagenum', '%#%' ),
		    'format' => '',
		    'prev_text' => __( '‹', appBook()->slug ),
		    'next_text' => __( '›', appBook()->slug ),
		    'total' => $num_of_pages,
		    'current' => $pagenum,
		    'show_all' => false,
		    'end_size' => 3,
		    'mid_size' => 3
		) );
	?>
	<div class="tablenav top">
		<ul class="subsubsub">
			<?php if (isset($_POST["cs"])) { ?>
				<?php if ($total) { ?>
			<li class="all"><?php _e("Résultat de recherche pour", $app->slug); ?> "<?php echo $_POST["cs"]; ?>" <span class="count">(<?php echo $total ?>)</span> | <a href="<?php echo admin_url('admin.php?page=app-rdv') ?>"><?php echo _e("Tous") ?><span class="count">(<?php echo $total_all ?>)</span></a></li>
				<?php }else { ?>
			<li class="all"><?php _e("Aucun résultat pour ", $app->slug) ?> "<?php echo $_POST["cs"]; ?>" | <a href="<?php echo admin_url('admin.php?page=app-rdv') ?>"><?php _e("Tous", $app->slug) ?> <span class="count">(<?php echo $total_all ?>)</span></a></li>
				<?php } ?>
			<?php }else { ?>
			<li class="all">Tous <span class="count">(<?php echo $total_all ?>)</span></li>
			<?php } ?>
		</ul>
		<div class="tablenav-pages">
			<span class="pagination-links">
				<?php echo $page_links ?>
			</span>
		</div>
	</div>
	<?php if ($total) { ?>
	<table class="wp-list-table widefat fixed striped">
		<thead>
			<tr>
				<th scope="col" class="manage-column checking"><input type="checkbox" class="module_all" name="module_all"></th>
				<th scope="col" class="manage-column app-name"><?php _e('Société', appBook()->slug) ?></th>
				<th scope="col" class="manage-column app-link"><?php _e('Lien du module', appBook()->slug) ?></th>
				<th scope="col" class="manage-column app-comments"><?php _e('Commentaires', appBook()->slug) ?></th>
				<th scope="col" class="manage-column app-actions"><?php _e('Supprimer', appBook()->slug) ?></th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th scope="col" class="manage-column checking"><input type="checkbox" class="module_all" name="module_all"></th>
				<th scope="col" class="manage-column app-name"><?php _e('Société', appBook()->slug) ?></th>
				<th scope="col" class="manage-column app-link"><?php _e('Lien du module', appBook()->slug) ?></th>
				<th scope="col" class="manage-column app-comments"><?php _e('Commentaires', appBook()->slug) ?></th>
				<th scope="col" class="manage-column app-actions"><?php _e('Supprimer', appBook()->slug) ?></th>
			</tr>
		</tfoot>
		<tbody>
		<?php foreach ($all as $key => $single) { ?>
			<tr id="<?php echo $single->app_id ?>">
				<td class="checking"><?php if($single->module_id !== null) : ?><input type="checkbox" class="module-rdv" name="module[]" value="<?php echo $single->app_id ?>"><?php endif; ?></td>
				<td class="app-name"><?php echo $single->app_name; ?></td>
				<?php 
				if($single->module_id === null)
					$folder_text = __('Pas encore généré', appBook()->slug);
				else
					$folder_text = site_url('/').$single->folder.'/';
				?>
				<td class="app-link"><?php echo $folder_text; ?></td>
				<td class="app-comments"><textarea name="comment" style="width: 100%"><?php echo $single->comments ?></textarea><br /><button data-id="<?php echo $single->app_id ?>" data-module="<?php echo $single->module_id ?>" type="button" name="save_comments" class="save-comments button button-primary"><?php echo _('Enregistrer') ?></button></td>
				<td class="app-actions"><button data-id="<?php echo $single->app_id ?>" type="button" class="delete-app button button-secondary"><?php echo _('Supprimer') ?></button></td>
			</tr>
		<?php 
		}
		?>
		</tbody>
	</table>
	<div class="tablenav bottom">
		<div class="tablenav-pages">
			<span class="pagination-links">
				<?php echo $page_links ?>
			</span>
		</div>
	</div>
	<?php } ?>
</div>
<script type="text/javascript">
	jQuery('.module_all').change(function(){
		jQuery('.module-rdv').prop("checked", this.checked);
		jQuery('.module_all').prop("checked", this.checked);
	});
	jQuery('.module-rdv').change(function(){
		jQuery('.module-rdv').each(function(i){
			if (this.checked == false)
			{
				jQuery('.module_all').prop("checked", false);
				return;
			}
		});
	});
	jQuery('#regenerate-module').click(function(){
		var ajaxurl = '<?php echo admin_url( 'admin-ajax.php' ) ?>';
		if ( jQuery('.module-rdv').is(":checked") === false )
		{
			alert("<?php echo __('Veuillez cocher une ou plusieurs société(s).') ?>");
			return false;
		}
		if (jQuery('.module_all').is(":checked") == true)
		{
			var confirmRegenerateAll = confirm('Voulez-vous régénérer tous les modules?');
			if (confirmRegenerateAll === true) {
				jQuery('#app-loading').show();
				jQuery.post(
				    ajaxurl, 
				    {
				        'action': '<?php echo appBook()->slug.'_regenerate_module' ?>',
				        'data': 'all'
				    }, 
				    function(response){
				    	jQuery('#app-loading').hide();
				    	if (response == "1"){
				        	alert('La régénération de tous les modules a été effectuée.');
				        	// jQuery('#rdv-title').before('<div>La régénération de tous les modules a été effectuée.</div>');
				    	}
				        else
				        	alert('Erreur');
				    }
				);
			}
		}else {
			var confirmRegenerate = confirm('Voulez-vous vraiment régénérer?');
			if (confirmRegenerate === true)
			{
				jQuery('#app-loading').show();
				var inputs = jQuery('.module-rdv');
				var ids = '';
				inputs.each(function(i){
					ids += (i!=0?',':'')+ijQuery(this).val();
				});
				jQuery.post(
				    ajaxurl, 
				    {
				        'action': '<?php echo appBook()->slug.'_regenerate_module' ?>',
				        'data': ids
				    }, 
				    function(response){
				    	jQuery('#app-loading').hide();
				    	if (response == "1"){
				        	alert('La régénération a été effectuée.');
				    	}
				        else
				        	alert('Erreur');
				    }
				);
			}else {
				return false;
			}
		}
	});

	// save comment
	jQuery('.save-comments').click(function(){
		var confirmation = confirm('<?php _e('Voulez-vous enregistrer le commentaire?', $app->slug); ?>');
		if (confirmation === true)
		{
			saveComment(this);
		}
	});
	function saveComment(app)
	{
		jQuery('#app-loading').show();
		var ajaxurl = '<?php echo admin_url( 'admin-ajax.php' ) ?>';
		var posting = jQuery.post(
			ajaxurl,
			{
				'action': '<?php echo appBook()->slug.'_update_comment' ?>',
				'app_id': jQuery(app).data('id'),
				'module_id': jQuery(app).data('module'),
				'comment': jQuery('tr#'+jQuery(app).data('id')+' textarea[name="comment"]').val(),
			}
		);
		posting.done(function(response){
			jQuery('#app-loading').hide();
			if(response == '0'){
				alert("<?php echo __("Le commentaire n'a pas été enregistré.", $app-slug); ?>");
			}
			if(response == '1'){
				alert('<?php echo __('Le commentaire a été enregistré avec succès.', $app-slug); ?>');
			}
		});
	}

	// delete
	jQuery('.delete-app').click(function(){
		var confirmDelete = confirm('<?php _e('Voulez-vous vraiment supprimer cette société et toutes ses données?', $app->slug) ?>');
		if(confirmDelete === true)
		{
			deleteApp(this);
		}
	});
	function deleteApp(app){
		jQuery('#app-loading').show();
		var ajaxurl = '<?php echo admin_url( 'admin-ajax.php' ) ?>';
		var posting = jQuery.post(
			ajaxurl,
			{
				'action': '<?php echo appBook()->slug.'_delete_app' ?>',
				'app_id': jQuery(app).data('id'),
			}
		);
		posting.done(function(response){
			jQuery('#app-loading').hide();
			if(response == '1'){
				alert('<?php echo __('La société a été supprimée avec succès.', $app-slug); ?>');
				jQuery('tr#'+jQuery(app).data('id')).remove();
			}
			else if(response == '0'){
				alert("<?php echo __("La société n'a pas été supprimée.", $app-slug); ?>");
			}
			else{
				alert(response);
			}
		});
	}
</script>