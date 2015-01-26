<?php
namespace App\Handlers\Commands\V1\Finance\Bcentral;

use Cache;
use App\Commands\V1\Finance\Bcentral\DailyIndexesCommand;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class DailyIndexesCommandHandler
 * @package App\Handlers\Commands\V1\Finance\Bcentral
 */
class DailyIndexesCommandHandler
{
	/**
	 * Response labels
	 *
	 * @var array
	 */
	protected $parsePattern = [
		'label',
		'value',
		'currency',
	];

	/**
	 * Hardcoded query patterns
	 *
	 * @var array
	 */
	protected $patterns = [
		'uf' => [
			'Unidad\sde\sFomento \(UF\)',
			'Unidad\sde\sFomento',
			'UF',
		],
		'usd' => [
			'Dólar\sObservado',
			'Dólar',
			'USD',
		],
		'eur' => [
			'Euro',
			'Euro\s\(pesos\spor\seuro\)',
			'Pesos',
		],
		'eur_usd' => [
			'Euro',
			'Euro\s\(euros\spor\sdólar\)',
			'Dólar\sUSA',
		],
		'mp_cu' => [
			'Cobre\s\(US\$\/libra\)',
			'Cobre',
			'Dólar\sUSA',
		],
		'mp_au' => [
			'Oro\s\(US\$\/ozt\)',
			'Oro',
			'Dólar\sUSA',
		],
		'tpm' => [
			'Tasa\sde\spolítica\smonetaria\s\(TPM\)',
			'Tasa\sde\spolítica\smonetaria',
			'TPM',
			'Porcentaje',
		],
	];

	/**
	 * @var Crawler
	 */
	protected $crawler;

	/**
	 * Create the command handler.
	 *
	 * Load the main crawler
	 */
	public function __construct()
	{
		$this->crawler = new Crawler();
	}

	/**
	 * Handle the command.
	 *
	 * @param DailyIndexesCommand $command
	 * @return array|mixed
	 */
	public function handle(DailyIndexesCommand $command)
	{
		// Try to load data from cache

		// If no cache exists, we create it
		if (!Cache::has("finance_bcentral.{$command->getTask()}.data")) {
			$data = $this->loadData($command->content);
			Cache::put(
				"finance_bcentral.{$command->getTask()}.data",
				$data,
				array_get($command->config, 'expire', 30)
			);
		} else {
			// Returns an existent cache
			$data = Cache::get("finance_bcentral.{$command->getTask()}.data");
		}

		// Returns the cached data
		return $data;
	}

	/**
	 * Load the data based on the content received
	 *
	 * @param $content
	 * @return array
	 */
	protected function loadData($content)
	{
		// Load UTM and Daily Indexes together
		$utmContent = $content['utm'];
		$diContent  = $content['di'];

		//$utmData    = $this->loadUTMData($utmContent); // todo append UTM value
		$diData     = $this->loadDIData($diContent);

		return $diData;
	}

	/**
	 * Load UTM data from HTML content
	 *
	 * @param $content
	 */
	protected function loadUTMData($content)
	{
		// Load UTM content
	}

	/**
	 * Load Daily indexes from HTML content
	 *
	 * @param $content
	 * @return array
	 */
	protected function loadDIData($content)
	{
		// Initilize de crawler
		$this->crawler->addHtmlContent($content);
		// Get the content tables
		$tables  = $this->crawler->filter('table.tableUnits.table');
		$arrayTable = [];
		// Scan each table
		foreach ($tables as $domElement) {
			// Transform valida tables to an array representation
			$arrayData      = $this->htmlTableToArray($domElement);
			$arrayTable[$arrayData[0]['name']] = $arrayData;
		}

		// Return the array values
		return $arrayTable;
	}

	/**
	 * Parse an HTML table into an PHP array
	 *
	 * @param \DOMElement $table
	 * @return array
	 */
	protected function htmlTableToArray(\DOMElement $table)
	{
		// Crawl the table and search for TR rows
		$table  = new Crawler($table);
		$trs    = $table->filter('tr');
		/**
		 * @var Crawler $trs
		 * @var \DOMElement $tr
		 */
		$rowValues  = [];
		// For each row scan its cells for values
		foreach ($trs as $tr) {
			$tds            = (new Crawler($tr))->filter('td');
			$rowValues[]    = $this->detectField($tds);
		}

		return $rowValues;
	}

	/**
	 * Detect the field type and append the cell value to it
	 *
	 * @param $tds
	 * @return array
	 */
	protected function detectField($tds)
	{
		/**
		 * @var Crawler $row
		 * @var Crawler $td
		 */
		$values = [];
		foreach ($tds as $td) {
			// Text value
			$values[] = $td->nodeValue;
		}

		$field    = null;
		// Evaluate each value and assign scores to detect the field type
		$maxScore = 0;
		foreach ($this->patterns as $key => $pattern) {
			$score = 0;
			// Score based on defined patterns (hardcoded)
			foreach ($pattern as $p) {
				foreach ($values as $val) {
					if (preg_match("/$p/i", $val)) {
						$score++;
					}
				}
			}

			// If we hit the biggest score then we detected the field type
			// Hopefully
			if ($score > $maxScore) {
				$maxScore = $score;
				$field    = $key;
			}
		}

		// Populate the result
		$result = [
			'name' => $field,
		];
		reset($this->parsePattern);
		// Create value => key of field
		foreach ($values as $value) {
			$current = current($this->parsePattern);
			if ($current) {
				$result[$current] = $value;
				next($this->parsePattern);
			}
		}

		return $result;
	}
}
