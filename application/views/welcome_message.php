<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container mt-5 text-center mb-4">
	<h1>Welcome To <b>User Management System</b> Home Page!</h1>

	<img src="<?php echo base_url('assets/images/ums.jpg'); ?>" alt="UMS" width="400">

	<div id="body">
		<h3>The page you are looking at is being generated dynamically by CodeIgniter and updated to the view you see!</h3>

		<h3>If you would like to dive in the project click <a href="<?php echo site_url('login') ?>">Here</a></h3>
		
	</div>

	
</div>
<div class="d-flex justify-content-end">
	<p>Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
</div>