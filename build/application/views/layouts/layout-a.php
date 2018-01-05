<?php if(isset($header)){ ?>
{header}
<?php } ?>

	<div id="wrapper">
		<!-- Begin: Content Area -->
		
					{content}
		
		<!-- End: Content Area -->
		<?php if(isset($sidebarActive) && $sidebarActive){?>
		<!-- Begin: Sidebar -->
		<div id="sidebar">
				
					{sidebar}
				
		</div>
		<!-- End: Sidebar -->
		<?php };?>
	</div>
	<?php if(isset($footer)){ ?>
{footer}
<?php } ?>

