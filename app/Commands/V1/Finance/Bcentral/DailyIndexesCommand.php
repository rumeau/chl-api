<?php
namespace App\Commands\V1\Finance\Bcentral;

use App\Commands\Command;

/**
 * Class DailyIndexesCommand
 * @package App\Commands\V1\Finance\Bcentral
 */
class DailyIndexesCommand extends Command
{
	public static $task = 'daily_indexes';

	/**
	 * @var array|string
     */
	public $content;

	/**
	 * @var array
	 */
	public $config;

	/**
	 * @param $content
	 * @param array $config
	 */
	public function __construct($content, $config = [])
	{
		$this->content = $content;
		$this->config  = $config;
	}

	/**
	 * Get the command task
	 *
	 * @return string
	 */
	public function getTask()
	{
		return static::$task;
	}
}
