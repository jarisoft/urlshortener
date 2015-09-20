<div class="container-fluid">
	<a id="service"></a>
	<div class="row">
		<div class="col-md-10 col-md-offset-1 col-xs-12">
			<p>Enter the url you want to create a shorter URL from into the input
				field and click 'create'</p>
			<form role="form" class="" action="/" method="POST">
				<label for="input_field">Enter URL</label><input type="text"
					name="input_field" class="form-control"
					placeholder="Your URL goes in here"> <input type="hidden"
					name="random_key" value="<?php echo $data['random_key'];?>"> <input
					type="submit" name="submit_create" value="Create URL"
					class="btn btn-primary"> <input type="submit" name="submit_lookup"
					value="Lookup URL" class="btn btn-success">
			</form>
		</div>
	</div>

</div>
