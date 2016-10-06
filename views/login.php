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
						<h2>Login</h2>
					</div>
					<!-- End Box Head -->
					
					<form action="/login" method="post" id="login-form">
						
						<!-- Form -->
						<div class="form">
								<p>
									<label>Login</label>
									<input type="text" class="field size1" name="login" />
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
                    
                    <script src="/js/forms.js"></script>
                    
				</div>
				<!-- End Box -->

			</div>
			<!-- End Content -->
						
			<div class="cl">&nbsp;</div>			
		</div>
		<!-- Main -->
	</div>
</div>
<!-- End Container -->