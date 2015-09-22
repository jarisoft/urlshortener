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
