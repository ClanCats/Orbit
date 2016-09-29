<?php 

namespace ClanCats\Orbit\Tests;

use ClanCats\Orbit\Manager;

/**
 * Orbit manager tests
 ** 
 *
 * @package 		Orbit
 * @copyright 		Mario Döring
 *
 * @group Orbit
 * @group Orbit_Manager
 */
class ManagerTest extends \PHPUnit_Framework_TestCase
{	
	protected function create(array $configuration = array())
	{
		Manager::register(array_merge(array('cache' => __DIR__ . '/../cache/'), $configuration));
	}

	protected function destroy()
	{
		Manager::unload();
	}

	protected function setUp()
    {
        $this->create();
    }

    protected function tearDown()
    {
    	// only destroy if registered
    	if (Manager::finder())
    	{	
    		$this->destroy();
    	}
    }

	/**
	 * Manager::register
	 */
	public function testRegisterAndUnload()
	{	
		$this->assertInstanceOf("ClanCats\Orbit\Finder", Manager::finder());

		// now unload the orbit
		Manager::unload();

		// now it should be null
		$this->assertNull(Manager::finder());
	}

	/**
	 * Manager::register
	 *
	 * @expectedException ClanCats\Orbit\Exception
	 */
	public function testDoubleRegistration()
	{	
		// Register antoher one
		$this->create();
	}

	/**
	 * Manager::register
	 *
	 * @expectedException ClanCats\Orbit\Exception
	 */
	public function testUnregisteredUnload()
	{	
		// Destroy the current one
		$this->destroy();

		// and destroy 
		$this->destroy();
	}

	/**
	 * Manager::__callStatic
	 *
	 * @expectedException ClanCats\Orbit\Exception
	 */
	public function testCallWithoutRegistration()
	{	
		// destroy the current one
		$this->destroy();

		// try to call
		Manager::someMethod();
	}

	/**
	 * Manager::__callStatic
	 *
	 * @expectedException BadMethodCallException
	 */
	public function testInvalidMethod()
	{	
		Manager::thisMethodDoesNotExistAtAllYeah();
	}
}