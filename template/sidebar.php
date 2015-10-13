<div id="content">
	<div class="sidebar">
		<!-- This adds a sidebar -->
		<div id="menubar">
			<div class="menu">
				
				<h1> Categories </h1>
				<hr>
				<ul>
					<!-- List of categories  -->
					<?php 
						if(!empty($cats)){
							foreach($cats as $cat) {
								echo "<li><a href=\"?page=categories&amp;category=".$cat['id']."\"";
								echo Check::getActive(array('category' => $cat['id']));
								echo ">";
								echo Check::encodeHtml($cat['name']);
								echo "</a></li>";
							}
						}
					?>
				</ul>
			</div>
		</div>
	</div>
	<div class="mainContent">