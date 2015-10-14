<?php 

Login::noAccess();

$theUser = new User();
$user = $theUser->getUser(Session::getSession(Login::$user_login));

if(!empty($user)){

$form = new Form();
$validation = new Valid($form);


if ($form->isPost('first_name')) {
		
	$validation->expect = array(
		'first_name',
		'last_name',
		'address_1',
		'address_2',
		'city',
		'county',
		'post_code',
		'country',
		'email'
	);
	
	$validation->requirement = array(
		'first_name',
		'last_name',
		'address_1',
		'city',
		'post_code',
		'country',
		'email'
	);
	
	$validation->spec_field = array('email' => 'email');
	
	if($validation->isValid()) {
		if($theUser->updateUser($validation->post, $user['id'])){
			Check::redirect('?page=summary');
		} else {
			$message = "<p style=\"color: red;\">We cannot update your details.</p>";
		}
	}
	
}

require_once('header.php');
require_once('navigation.php');
require_once('sidebar.php');

?>

<div id="order">
	<h1>Checkout</h1>
	<p>Please check your details and click <strong>Next</strong>.</p>
	
	<h2>Shipping address:</h2>
	<br />
	
	<?php echo !empty($message) ? $message : null; ?>
	
	<form name="order" action="" method="post">
		<table>
			<tr>
				<th>
					<label for="first_name">First name: <span>*</span></label>
				</th>
				<td>
					<?php echo $validation->warn('first_name'); ?>
					<input type="text" name="first_name" 
					id="first_name" class="ship_input" 
					value="<?php echo $form->textField('first_name', $user['first_name']); ?>" />
				</td>
			</tr>
			<tr>
				<th>
					<label for="last_name">Last name: <span>*</span></label>
				</th>
				<td>
					<?php echo $validation->warn('last_name'); ?>
					<input type="text" name="last_name" 
					id="last_name" class="ship_input" 
					value="<?php echo $form->textField('last_name', $user['last_name']); ?>" />
				</td>
			</tr>
			<tr>
				<th>
					<label for="address_1">Address 1: <span>*</span></label>
				</th>
				<td>
					<?php echo $validation->warn('address_1'); ?>
					<input type="text" name="address_1" 
					id="address_1" class="ship_input" 
					value="<?php echo $form->textField('address_1', $user['address_1']); ?>" />
				</td>
			</tr>
			<tr>
				<th>
					<label for="address_2">Address 2: </label>
				</th>
				<td>
					<?php echo $validation->warn('address_2'); ?>
					<input type="text" name="address_2" 
					id="address_2" class="ship_input" 
					value="<?php echo $form->textField('address_2', $user['address_2']); ?>" />
				</td>
			</tr>
			<tr>
				<th>
					<label for="city">City: <span>*</span></label>
				</th>
				<td>
					<?php echo $validation->warn('city'); ?>
					<input type="text" name="city" 
					id="city" class="ship_input" 
					value="<?php echo $form->textField('city', $user['city']); ?>" />
				</td>
			</tr>
			<tr>
				<th>
					<label for="county">County: </label>
				</th>
				<td>
					<?php echo $validation->warn('county'); ?>
					<input type="text" name="county" 
					id="county" class="ship_input" 
					value="<?php echo $form->textField('county', $user['county']); ?>" />
				</td>
			</tr>
			<tr>
				<th>
					<label for="post_code">Postcode: <span>*</span></label>
				</th>
				<td>
					<?php echo $validation->warn('post_code'); ?>
					<input type="text" name="post_code" 
					id="post_code" class="ship_input" 
					value="<?php echo $form->textField('post_code', $user['post_code']); ?>" />
				</td>
			</tr>
			<tr>
				<th>
					<label for="country">Country: <span>*</span></label>
				</th>
				<td>
					<?php echo $validation->warn('country'); ?>
					<input type="text" name="country" 
					id="country" class="ship_input" 
					value="<?php echo $form->textField('country', $user['country']); ?>" />
				</td>
			</tr>
			<tr>
				<th>
					<label for="email">Email: <span>*</span></label>
				</th>
				<td>
					<?php echo $validation->warn('email'); ?>
					<input type="text" name="email" 
					id="email" class="ship_input" 
					value="<?php echo $form->textField('email', $user['email']); ?>" />
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<label for="next" class="next">
					<input type="submit" id="next" class="next_btn" value="Next" />
					</label>
				</td>
			</tr>
		</table>
	</form>
</div>

<?php
	require_once('footer.php'); 

} else {
	Check::redirect('?page=error');
}
	
	?>