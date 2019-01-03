<?php
namespace App\Models;
use Closure;
use Illuminate\Database\Eloquent\Model;
use Exception;
use PDOException;

/**
 * Class EloquentModel
 * @package App\Models
 * @property string $extra_data
 */
class EloquentModel extends Model
{
	/**
	 * @param Closure $callback
	 * @param int $attempts
	 * @return mixed
	 * @throws Exception
	 */
	public static function transaction(Closure $callback, $attempts = 2)
	{
		$connection = (new static())->getConnection();
		for ($currentAttempt = 1; $currentAttempt <= $attempts; $currentAttempt++) {
			$connection->beginTransaction();

			try {
				$result = $callback();
				$connection->commit();
			} catch (Exception $error) {
				$connection->rollBack();

				// 抛出非POD错误时，不再重试
				if ($currentAttempt < $attempts &&
                    $error instanceof PDOException) {
					continue;
				}
				throw $error;
			}

			return $result;
		}

		return true;
	}
}