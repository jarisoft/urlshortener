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

<div class="container-fluid">
	<a id="service"></a>
	<div class="row">
		<div class="col-md-10 col-md-offset-1 col-xs-12">
			<p>Enter the url you want to create a shorter URL from into the input
				field and click 'create'</p>
			<form role="form" class="" action="/" method="POST">
				<label for="input_field">Enter URL</label><input required type="url"
					name="input_field" class="form-control"
					placeholder="Your URL goes in here"> <input type="hidden"
					name="random_key" value="<?php echo $data['random_key'];?>"> <input
					type="submit" name="submit_create" value="Create URL"
					class="btn btn-primary"> <input type="submit" name="submit_lookup"
					value="Lookup URL" class="btn btn-success">
			</form>
			<hr>
		</div>
	</div>

</div>
