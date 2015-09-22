<!-- 
 * Copyright 2015 Jakob
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 
 -->
<div class="row">
	<a id="result"></a>
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
				<td><a href="<?php echo $url->getFullShortUrl();?>" target="_blank"><?php echo $url->getFullShortUrl();?></a></td>
				<td><a href="<?php echo $url->getTarget();?>" target="_blank"><?php echo $url->getTarget();?></a></td>
				<td><?php echo $url->getDateCreatedFormatted();?></td>
				<td><?php echo $url->getDateExpiredFormatted();?></td>
			</tr>
		</table>
			
			<?php } else { ?>
			
			No match found for <?php
    
    echo $data['lookup'];
}
?>
<hr>
	</div>
</div>
