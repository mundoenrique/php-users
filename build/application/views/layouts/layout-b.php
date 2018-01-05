<?php if(isset($header)){ ?>
{header}
<?php } ?>

	<div id="wrapper">
		<!-- Begin: Content Area -->
		<?php if(isset($sidebarActive) && $sidebarActive){?>
		<!-- Begin: Sidebar -->
		<div id="sidebar">
					{sidebar}
		</div>
		<!-- End: Sidebar -->
		<?php };?>
		
					{content}
		
		<!-- End: Content Area -->
	</div>
	<?php if(isset($footer)){ ?>
{footer}
<?php } ?>