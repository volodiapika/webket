<!-- Container -->
<div id="container">
	<div class="shell">
		
		<!-- Message OK -->		
		<div class="msg msg-ok hidden-tag">
			<p><strong>Your login succesifully!</strong></p>
			<a href="/" class="close">close</a>
		</div>
		<!-- End Message OK -->		
		
		<!-- Message Error -->
		<div class="msg msg-error hidden-tag">
			<p><strong>You must select corect data!</strong></p>
			<a href="/" class="close">close</a>
		</div>
		<!-- End Message Error -->
		<br />
		<!-- Main -->
		<div id="main">
			<div class="cl">&nbsp;</div>
			
			<!-- Content -->
			<div id="content">
				
				<!-- Box -->
				<div class="box">
					<!-- Box Head -->
					<div class="box-head">
						<h2 class="left">List users</h2>
					</div>
					<!-- End Box Head -->	

					<!-- Table -->
					<div class="table">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<th>Firstname Lastname</th>
								<th>Login</th>
								<th width="110" class="ac">Content Control</th>
							</tr>
                            <?php if (isset($posts['list'])): ?>
                            	<?php foreach ($posts['list'] as $key => $value): ?>
									<tr id="list_<?php echo $value->id; ?>">
										<td><h3><a><?php echo $value->firstname; ?> <?php echo $value->lastname; ?></a></h3></td>
										<td><a><?php echo $value->login; ?></a></td>
										<td><a class="ico del" data-id="<?php echo $value->id; ?>">Delete</a><a href="#box-edit-user" class="ico edit" data-id="<?php echo $value->id; ?>" data-firstname="<?php echo $value->firstname; ?>" data-lastname="<?php echo $value->lastname; ?>" data-login="<?php echo $value->login; ?>" data-password="<?php echo $value->password; ?>" data-role="<?php echo $value->role; ?>">Edit</a></td>
									</tr>
							    <?php endforeach; ?>
						    <?php endif; ?>
						</table>
					</div>
					<!-- Table -->
					
				</div>
				<!-- End Box -->
                
				<!-- Box -->
				<div class="box" id="box-edit-user">
					<!-- Box Head -->
					<div class="box-head">
						<h2>Edit</h2>
					</div>
					<!-- End Box Head -->
					
					<form action="/user-update" method="post" id="edit-user">
                        <input type="hidden" name="id" />

						<!-- Form -->
						<div class="form">
								<p>
									<label>Login</label>
									<input type="text" class="field size1" name="login" />
								</p>
								<p>
									<label>Firstname</label>
									<input type="text" class="field size1" name="firstname" />
								</p>
								<p>
									<label>Lastname</label>
									<input type="text" class="field size1" name="lastname" />
								</p>
								<p>
									<label>Role</label>
									<input type="text" class="field size1" name="role" />
								</p>
								<p>
									<label>Password</label>
									<input type="password" class="field size1" name="password" />
								</p>
							
						</div>
						<!-- End Form -->
						
						<!-- Form Buttons -->
						<div class="buttons">
							<input type="submit" class="button" value="submit" />
						</div>
						<!-- End Form Buttons -->
					</form>
                    
				</div>
				<!-- End Box -->

				<script src="/js/forms.js"></script>

			</div>
			<!-- End Content -->
						
			<div class="cl">&nbsp;</div>			
		</div>
		<!-- Main -->
	</div>
</div>
<!-- End Container -->
