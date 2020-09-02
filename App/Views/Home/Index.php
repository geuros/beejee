<div class="cotainer">
	<form action="/task/add" method="post" class="needs-validation" novalidate>
		<div class="form-row">
			<div class="form-group col-md-3">
				<input name="s_user_name" type="text" class="form-control" placeholder="User Name" required value="<?php echo $this->a_form_data[ 's_user_name' ] ?>"/>
			</div>
			<div class="form-group col-md-3">
				<input name="s_email" type="email" class="form-control" placeholder="Email" required value="<?php echo $this->a_form_data[ 's_email' ] ?>"/>
			</div>
			<div class="form-group col-md-4">
				<textarea name="s_text" class="form-control" placeholder="Text" required><?php echo $this->a_form_data[ 's_text' ] ?></textarea>
			</div>
			<div class="form-group col-md-2">
				<button type="submit" class="btn btn-primary">Add Task</button>
			</div>
		</div>
	</form>
</div>
<?php if ( empty( $this->a_tasks ) == false ) { ?>
	<div class="container">
		<table class="table">
			<thead>
			<tr>
				<th scope="col"><?php echo $this->htmlSortLink( 'i_id', '#' ); ?></th>
				<th scope="col"><?php echo $this->htmlSortLink( 's_user_name', 'User Name' ); ?></th>
				<th scope="col"><?php echo $this->htmlSortLink( 's_email', 'Email' ); ?></th>
				<th scope="col">Text</th>
				<th scope="col" class="text-center"><?php echo $this->htmlSortLink( 'b_complete', 'Completed' ); ?></th>
				<th scope="col" class="text-center">Edited by Admin</th>
			</tr>
			</thead>
			<tbody>
			<?php foreach ( $this->a_tasks as $a_task ) { ?>
				<tr>
					<th scope="row"><?php echo $a_task[ 'i_id' ]; ?></th>
					<td><?php echo htmlspecialchars( $a_task[ 's_user_name' ] ); ?></a></td>
					<td><?php echo htmlspecialchars( $a_task[ 's_email' ] ); ?></a></td>
					<td>
						<?php
						if ( $this->getSession()->auth ) {
							?>
							<form action="/task/edit" method="post">
								<input type="hidden" name="i_id" value="<?php echo $a_task[ 'i_id' ]; ?>"/>
								<textarea name="s_text" class="form-control" placeholder="Text"
										  required><?php echo $a_task[ 's_text' ]; ?></textarea>
								<button type="submit" class="btn btn-secondary">Edit</button>
							</form>
							<?php
						} else {
							echo htmlspecialchars( $a_task[ 's_text' ] );
						}
						?>
					</td>
					<td class="text-center">
						<?php
						if ( $a_task[ 'b_complete' ] ) {
							$s_icon = 'check';
						} else {
							$s_icon = 'x';
						}
						?>
						<span class="oi oi-<?php echo $s_icon; ?>"></span>
						<?php
						if ( $this->getSession()->auth ) {
							?>
							<form action="/task/edit" method="post">
								<input type="hidden" name="i_id" value="<?php echo $a_task[ 'i_id' ]; ?>"/>
								<input type="hidden" name="s_task" value="toggle_status"/>
								<button type="submit" class="btn btn-secondary">Toggle Status</button>
							</form>
							<?php
						}
						?>
					</td>
					<td class="text-center">
						<?php
						if ( $a_task[ 'b_edited' ] ) {
							$s_icon = 'check';
						} else {
							$s_icon = 'x';
						}
						?>
						<span class="oi oi-<?php echo $s_icon; ?>"></span>
					</td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
		<?php echo $this->htmlPagination(); ?>
	</div>
<?php } ?>
