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
						<h2 class="left">View messages</h2>
					</div>
					<!-- End Box Head -->	

					<!-- Table -->
					<div class="table">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<th>Title</th>
								<th>Message</th>
							</tr>
                            <?php if (isset($posts['list'])): ?>
                            	<?php foreach ($posts['list'] as $key => $value): ?>
                            		<?php if (
                            				$value->idfrom == $posts['id'] ||
                            				$value->idto == $posts['id']
                            			):
                            		?>
										<tr id="list_<?php echo $value->id; ?>">
											<td>
												ID from <?php echo $value->idfrom; ?> to <?php echo $value->idto; ?>
												<h3><a><?php echo $value->title; ?></a></h3></td>
											</td>
											<td>
												<h3><a><?php echo $value->message; ?></a></h3></td>
											</td>
										</tr>
								    <?php endif; ?>
							    <?php endforeach; ?>
						    <?php endif; ?>
						</table>
					</div>
					<!-- Table -->
					
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