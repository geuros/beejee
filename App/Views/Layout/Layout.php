<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>BeeJee - Test Task</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
		  integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" href="/fonts/ionic-icons/css/open-iconic-bootstrap.min.css">
	<link href="/css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="container">
	<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
		<h5 class="my-0 mr-md-auto font-weight-normal">BeeJee</h5>
		<?php if ( empty( $this->getSession()->auth ) ) { ?>
			<a class="btn btn-outline-primary" href="/user/login">Sign up</a>
		<?php } else { ?>
			<a class="btn btn-outline-primary" href="/user/logout">Log out</a>
		<?php } ?>
	</div>
	<?php
	$a_messages = $this->getSession()->a_messages;
	if ( empty( $a_messages ) == false ) {
		foreach ( $a_messages as $a_message ) {
			?>
			<div class="alert alert-<?php echo $a_message[ 0 ]; ?>" role="alert">
				<?php echo $a_message[ 1 ]; ?>
			</div>
			<?php
		}

		unset( $this->getSession()->a_messages );
	}
	?>
	<?php echo $this->s_body; ?>
</div>
<!-- jQuery first, then Popper.js, and then Bootstrap's JavaScript -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
		integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
		crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
		integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
		crossorigin="anonymous"></script>
</body>
</html>