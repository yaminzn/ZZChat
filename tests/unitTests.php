<?php

require_once ('../modele/functions.php');

use PHPUnit\Framework\TestCase;

class unitTests extends PHPUnit_Framework_TestCase {

    public function testAddAccount() {
       $res = addUser("david", "plouf");

       $tabUser = returnUsersInfo()['users'][getUserId("david")];

       // res vaut 1 si tout s'est bien passé
       $this->assertEquals(checkUser("david", sha1("plouf")), $res);
       $this->assertNotEquals($tabUser, Array());

       $this->assertEquals($tabUser['username'], "david");
       $this->assertEquals($tabUser['level'], 0);
       $this->assertEquals($tabUser['color'], "#000000");
    }

    public function testSettingsUser(){
    	$user = "david";
    	$id = getUserId($user);

    	$tabUser = returnUsersInfo()['users'][$id];

    	$this->assertEquals($tabUser['color'], "#000000");

    	changeUsernameColor($id, "#666666");
    	$tabUser = returnUsersInfo()['users'][$id];

    	$this->assertEquals($tabUser['color'], "#666666");
    	$this->assertEquals(checkUser("david", sha1("plouf")), 1);

    	changeUsernamePassword($id, "plouf", "david");

    	$this->assertEquals(checkUser("david", sha1("david")), 1);

    }

    public function testChannel(){
    	// Set some session variable for the functions that use them
    	if(!isset($_SESSION)){
    		//session_start();
    		$_SESSION['userId'] = 0;
    		$_SESSION['currentChatId'] = 0;
    	}

    	$idChan = createChannel("Salon de test", "Pour les tests phpunit à la noix.");
    	$_SESSION['currentChatId'] = $idChan;

    	$chanInfo = returnChannelsInfo()['channel'][$idChan];

    	$this->assertEquals($chanInfo['id'], $idChan);
    	$this->assertEquals($chanInfo['name'], "Salon de test");
    	$this->assertEquals($chanInfo['description'], "Pour les tests phpunit à la noix.");
    	$this->assertEquals($chanInfo['userIdList'], [0]);

    	changeChannelName("Petit Salon de test");
    	changeChannelDescription("Kappa 1 2 3");
    	addUserToChannel(1, $idChan);

    	$chanInfo = returnChannelsInfo()['channel'][$idChan];

    	$this->assertEquals($chanInfo['name'], "Petit Salon de test");
    	$this->assertEquals($chanInfo['description'], "Kappa 1 2 3");
    	$this->assertEquals($chanInfo['userIdList'], [0, 1]);

    	removeUserFromChannel(0, $idChan);

    	$chanInfo = returnChannelsInfo()['channel'][$idChan];
    	$this->assertEquals($chanInfo['userIdList'], [1]);
    }


}