<?php 

namespace ClanCats\Orbit;

/**
 * The orbit manager is more a facade that holds
 * the singleton class of the finder object.
 */ 
class Manager
{	
	/**
	 * The finder singleton
	 *
	 * @var Finder
	 */
	protected static $finder = null;

	/**
	 * Returns the finder singleton 
	 *
	 * @return Finder|null
	 */
	public static function finder()
	{
		return static::$finder;
	}

	/**
	 * Register an finder singleton
	 *
	 * @param array 			$configuration
	 * @return void
	 */
	public static function register(array $configuration = array())
	{
		if (!is_null(static::$finder))
		{
			throw new Exception('There is already an finder registered, please unload that one first.');
		}

		// create new finder instance
		static::$finder = new Finder($configuration);

		// register the autoloader
		spl_autoload_register(array(static::$finder, 'autoload'), true, true);spl_autoload_unregister(array('Doctrine', 'autoload'));
	}

	/**
	 * Unload the finder
	 *
	 * @param array 			$configuration
	 * @return void
	 */
	public static function unload(array $configuration = array())
	{
		if (is_null(static::$finder))
		{
			throw new Exception('Cannot unload autoloader, there is no autoloader registered.');
		}

		// register the autoloader
		spl_autoload_unregister(array(static::$finder, 'autoload'));

		// kill the object
		static::$finder = null;
	}

	/**
	 * Forward calls to our singleton object
	 *
	 * @param string 				$name
	 * @param array 				$arguments
	 */
	public static function __callStatic($name, $arguments)
    {
    	if (is_null(static::$finder))
    	{
    		throw new Exception('Please initialize the orbit manager first with the "register" method.');
    	}

    	if (!method_exists(static::$finder, $name))
    	{
    		throw new \BadMethodCallException('ClanCats\\Oribt\\Manager does not implement method: ' . $name);
    	}

    	return call_user_func_array(array(static::$finder, $name), $arguments);
    }
}