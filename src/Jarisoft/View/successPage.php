
<div class="row">
	<a id="result"></a>
	<div class="col-md-10 col-md-offset-1 col-xs-12">
		<h3>Success</h3>
		<p> The shortened url for
		<?php
$shortURL = $data['shortURL'];
echo $shortURL->getTarget();
?>
		 is <a href="<?php echo $shortURL->getFullShortUrl();?>">
		 <?php echo $shortURL->getFullShortUrl();?></a>
		 and will be 
	expired by 
	<?php echo $shortURL->getDateExpiredFormatted();?>		
		
			
			
			
		
		
		<hr>
	</div>

</div>
