<?php $this->load->view('header'); ?>
<div class="page page-one">
	<h1 class="no-bold">Produced: <?php echo date('d M Y'); ?></h1>
	<h1>Licence to Occupy on Short Term Basis</h1>
	<h2><?php echo $booking['name'].", ".$booking['family_name']; ?></h2>
	<h2>Between</h2>
	<h1>PML SERVICES LTD</h2>
	<h2>And</h2>
	<h2><?php echo $booking['name'].", ".$booking['family_name']; ?></h2>
</div><!--./page page-one-->
<?php $this->load->view('footer'); ?>
