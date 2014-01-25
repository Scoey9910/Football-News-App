<?php

	echo $this->Form->create('LoginFootball');

	echo $this->Form->input('first_name');
	echo $this->Form->input('last_name');
	echo $this->Form->input('email', array(
		'label'	=> 'Email',
		'type' 	=> 'email',
	));
	echo $this->Form->input('address');
	echo $this->Form->input('state_code', array(
		'label'	=> 'State',
		'size'	=> 4,
	));
	echo $this->Form->input('zip_postal', array(
		'label'	=> 'Zip Code',
	));
	echo $this->Form->input('username');
	echo $this->Form->input('password', array(
		'label'	=> 'Password',
	));
	
	

	echo $this->Form->end('Join Now!'); 
?>