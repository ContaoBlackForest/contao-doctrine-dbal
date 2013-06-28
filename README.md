Doctrine DBAL Bridge
====================

This extension provide [Doctrine DBAL](http://www.doctrine-project.org) in the [Contao Open Source CMS](http://contao.org).
It only provide a service `$container['doctrine.connection.default']` to connect the default database with Doctrine DBAL.
To use the Doctrine Connection within the Contao Database Framework, use [bit3/contao-doctrine-dbal-driver](https://github.com/bit3/contao-doctrine-dbal-driver).

Use the doctrine connection
---------------------------

```php
class MyClass
{
	public function myFunc()
	{
		global $container;
		/** @var \Doctrine\DBAL\Connection $connection */
		$connection = $container['doctrine.connection.default'];

		$connection->query('...');
	}
}
```

Contao hooks
------------

`$GLOBALS['TL_HOOK']['prepareDoctrineConnection'] = function(&$connectionParameters, &$config) { ... }`
Called before the connection will be established.

`$GLOBALS['TL_HOOK']['doctrineConnect'] = function(&$connection) { ... }`
Called after the connection is established.

Define a custom connection
--------------------------

We prefer to use the [dependency injection container](https://github.com/bit3/contao-dependency-container):
Write a `system/config/services.php` or `system/modules/.../config/services.php`:
```php
$container['doctrine.connection.default'] = $container->share(
	function ($container) {
		$config = new \Doctrine\DBAL\Configuration();

		$connectionParameters = array(
			'dbname'   => $GLOBALS['TL_CONFIG']['dbDatabase'],
			'user'     => $GLOBALS['TL_CONFIG']['dbUser'],
			'password' => $GLOBALS['TL_CONFIG']['dbPass'],
			'host'     => $GLOBALS['TL_CONFIG']['dbHost'],
			'port'     => $GLOBALS['TL_CONFIG']['dbPort'],
		);

		switch (strtolower($GLOBALS['TL_CONFIG']['dbDriver'])) {
			// reuse connection
			case 'doctrinemysql':
				return \Database::getInstance()->getConnection();

			case 'mysql':
			case 'mysqli':
				$connectionParameters['driver']  = 'pdo_mysql';
				$connectionParameters['charset'] = $GLOBALS['TL_CONFIG']['dbCharset'];
				if (!empty($GLOBALS['TL_CONFIG']['dbSocket'])) {
					$connectionParameters['unix_socket'] = $GLOBALS['TL_CONFIG']['dbSocket'];
				}
				break;
			default:
				throw new RuntimeException('Database driver ' . $GLOBALS['TL_CONFIG']['dbDriver'] . ' not known by doctrine.');
		}

		if (!empty($GLOBALS['TL_CONFIG']['dbPdoDriverOptions'])) {
			$connectionParameters['driverOptions'] = deserialize($GLOBALS['TL_CONFIG']['dbPdoDriverOptions'], true);
		}

		return \Doctrine\DBAL\DriverManager::getConnection($connectionParameters, $config);
	}
);
```

Configure caching
-----------------

The caching implementation is defined in `$container['doctrine.cache.impl.default']` (default: `auto`).
By default, the caching implementation is detected by default, try this implementations in order: APC, Xcache, memcache, Redis, Array.

Possible settings are:

<table>
<tbody>
<tr>
<th>apc</th>
<td>use apc cache</td>
</tr>
<tr>
<th>xcache</th>
<td>use xcache cache</td>
</tr>
<tr>
<th>memcache://<host>[:<port>]</th>
<td>use memcache cache on <host>:<port></td>
</tr>
<tr>
<th>redis://<host>[:<port>]</th>
<td>use redis cache on <host>:<port></td>
</tr>
<tr>
<th>redis://<socket></th>
<td>use redis cache on <socket> file</td>
</tr>
<tr>
<th>array</th>
<td>use array cache</td>
</tr>
</tbody>
</table>

The caching time to live is defined in `$container['doctrine.cache.ttl.default']` (default: 0).

The caching key is defined in `$container['doctrine.cache.key.default']` (default: `contao_default_connection`).

To disable caching, set `$container['doctrine.cache.profile.default'] = null;`.
