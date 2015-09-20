<div class="container-fluid">
	<a id="result"></a>
	<div class="row">
		<div class="col-md-10 col-md-offset-1 col-xs-12">
			<h3>Lookup Result for <?php echo $data['lookup'];?></h3>
		Matching URL: 
		<?php
if ($data['match_found']) {
    $url = $data['match'];
    
    ?>
		<table class="table">
				<tr>
					<th>Short URL</th>
					<th>Target URL</th>
					<th>Created</th>
					<th>Expires</th>
				</tr>
				<tr>
					<td><a href="<?php echo $url->getFullShortUrl();?>"><?php echo $url->getFullShortUrl();?></a></td>
					<td><a href="<?php echo $url->getTarget();?>"><?php echo $url->getTarget();?></a></td>
					<td><?php echo $url->getDateCreatedFormatted();?></td>
					<td><?php echo $url->getDateExpiredFormatted();?></td>
				</tr>
			</table>
			
			<?php } else { ?>
			
			No match found for <?php
    
echo $data['lookup'];
}
?>
		</div>
	</div>
</div>
