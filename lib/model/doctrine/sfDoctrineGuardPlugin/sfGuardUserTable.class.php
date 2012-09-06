<?php

class sfGuardUserTable extends PluginsfGuardUserTable
{
	public function checkUsername($username) {
		$q = Doctrine_Query::create()
		->from('sfGuardUser')
		->where('username = ?', $username);
		$result = $q->execute();
		return $result[0]->username;
	}
}
