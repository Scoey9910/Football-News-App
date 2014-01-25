<?php

	class LoginFootballsController extends AppController
	{
		public $name = 'LoginFootballs';
		public $helpers = array('Html', 'form');
		
		public function index()
		{
			if ( $this->request->is('post') )
			{
				$data = $this->request->data;
				
				$this->LoginFootball->save($data);
				$this->redirect(array('action' => 'thanks'));
			}
			$this->set('title_for_layout','Football News');
		}
		
		public function thanks()
		{	
			$this->set('title_for_layout','Football News');
		}
		
	}

?>