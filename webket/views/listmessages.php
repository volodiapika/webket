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

				<!-- Small Nav -->
				<div class="small-nav">
					<a href="/view-messages/<?php echo $posts['idfrom']; ?>">View</a>
					<span>&gt;</span>
					messages<?php echo $posts['count']; ?>
				</div>
				<!-- End Small Nav -->
				
				<!-- Box -->
				<div class="box">
					<!-- Box Head -->
					<div class="box-head">
						<h2 class="left">List messages</h2>
					</div>
					<!-- End Box Head -->	

					<!-- Table -->
					<div class="table">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<th>Firstname Lastname</th>
								<th width="110" class="ac">Content Control</th>
							</tr>
                            <?php if (isset($posts['list'])): ?>
                            	<?php foreach ($posts['list'] as $key => $value): ?>
									<tr id="list_<?php echo $value->id; ?>">
										<td>
										<h3><a><?php echo $value->firstname; ?> <?php echo $value->lastname; ?></a></h3></td>
										<td>
										<a href="#box-edit-messages" class="ico edit message0" data-id="<?php echo $value->id; ?>">Send</a>
										</td>
									</tr>
							    <?php endforeach; ?>
						    <?php endif; ?>
						</table>
					</div>
					<!-- Table -->
					
				</div>
				<!-- End Box -->
                
				<!-- Box -->
				<div class="box" id="box-edit-messages">
					<!-- Box Head -->
					<div class="box-head">
						<h2>Edit</h2>
					</div>
					<!-- End Box Head -->
					
					<form action="/message-send" method="post" id="send-message">
                        <input type="hidden" name="idfrom" value="<?php echo $posts['idfrom']; ?>" />
                        <input type="hidden" name="idto" />

						<!-- Form -->
						<div class="form">
								<p>
									<label>Title</label>
									<input type="text" class="field size1" name="title" />
								</p>
								<p>
									<label>Message</label>
									<input type="text" class="field size1" name="message" />
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