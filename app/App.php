<?php
namespace App;

use App\Models\User;
use Pandora3\Libs\Application\Application;
use Pandora3\Core\Container\Container;
use Pandora3\Core\Interfaces\DatabaseConnectionInterface;
use Pandora3\Plugins\Authorisation\Interfaces\UserProviderInterface;
use Pandora3\Plugins\Eloquent\EloquentConnection;
use Pandora3\Plugins\Eloquent\EloquentUserProvider;

/**
 * @property-read EloquentConnection $database
 */
class App extends Application {

	protected function getUserModel(): string {
		return User::class;
	}

	/**
	 * {@inheritdoc}
	 */
	protected function getRoutes(): array {
		return include("{$this->path}/routes.php");
	}

	/**
	 * {@inheritdoc}
	 */
	protected function dependencies(Container $container): void {
		parent::dependencies($container);

		$container->setShared(DatabaseConnectionInterface::class, EloquentConnection::class);
		$container->setShared(UserProviderInterface::class, EloquentUserProvider::class);

		$container->set(EloquentUserProvider::class, function() {
			return new EloquentUserProvider($this->getUserModel());
		});

		if ($this->config->has('database')) {
			$connection = new EloquentConnection( array_replace(
				$this->config->get('database'), ['global' => true]
			));
			$container->setShared(EloquentConnection::class, function() use ($connection) {
				return $connection;
			});
		}
	}

}
