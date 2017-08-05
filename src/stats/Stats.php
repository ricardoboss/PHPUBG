<?php

namespace PHPUBG\stats;

use PHPUBG\matches\MatchMode;
use PHPUBG\Region;
use PHPUBG\Season;

class Stats implements \ArrayAccess, \Countable, \Iterator, \JsonSerializable {
	/** @var array An array of {@see Stat}s. */
	protected $stats = [];

	/** @var Region The region for the stats. */
	protected $region;

	/** @var Season The season for the stats. */
	protected $season;

	/** @var MatchMode The match mode for the stats. */
	protected $matchMode;

	/**
	 * Stats constructor.
	 *
	 * @param Region    $region
	 * @param Season    $season
	 * @param MatchMode $matchMode
	 * @param array     $statsArray The stats received by the api.
	 */
	public function __construct(Region $region, Season $season, MatchMode $matchMode, array $statsArray) {
		$this->region = $region;
		$this->season = $season;
		$this->matchMode = $matchMode;

		foreach ($statsArray as $stat)
			$this->stats[] = new Stat($stat);
	}

	/**
	 * Get all stats in a specific category.
	 *
	 * @param \PHPUBG\stats\StatCategory $category The category to filter
	 *
	 * @return array An array of {@see \PHPUBG\stats\Stat} objects with the selected category.
	 */
	public function getFromCategory(StatCategory $category) {
		$arr = [];

		foreach ($this->stats as $stat)
			if ($stat->getCategory() == $category)
				$arr[] = $stat;

		return $arr;
	}

	/**
	 * @return MatchMode
	 */
	public function getMatchMode(): MatchMode {
		return $this->matchMode;
	}

	/**
	 * @return Region
	 */
	public function getRegion(): Region {
		return $this->region;
	}

	/**
	 * @return Season
	 */
	public function getSeason(): Season {
		return $this->season;
	}

	/**
	 * Whether a offset exists
	 *
	 * @link  http://php.net/manual/en/arrayaccess.offsetexists.php
	 *
	 * @param mixed $offset <p>
	 *                      An offset to check for.
	 *                      </p>
	 *
	 * @return boolean true on success or false on failure.
	 * </p>
	 * <p>
	 * The return value will be casted to boolean if non-boolean was returned.
	 * @since 5.0.0
	 */
	public function offsetExists($offset): boolean {
		return isset($this->stats[$offset]);
	}

	/**
	 * Offset to retrieve
	 *
	 * @link  http://php.net/manual/en/arrayaccess.offsetget.php
	 *
	 * @param mixed $offset <p>
	 *                      The offset to retrieve.
	 *                      </p>
	 *
	 * @return Stat Returns a specific stat.
	 * @since 5.0.0
	 */
	public function offsetGet($offset): Stat {
		return $this->stats[$offset];
	}

	/**
	 * Offset to set
	 *
	 * @link  http://php.net/manual/en/arrayaccess.offsetset.php
	 *
	 * @param mixed $offset <p>
	 *                      The offset to assign the value to.
	 *                      </p>
	 * @param mixed $value  <p>
	 *                      The value to set.
	 *                      </p>
	 *
	 * @return void
	 * @since 5.0.0
	 */
	public function offsetSet($offset, $value) {
		if (is_null($offset)) {
			$this->stats[] = $value;
		} else {
			$this->stats[$offset] = $value;
		}
	}

	/**
	 * Offset to unset
	 *
	 * @link  http://php.net/manual/en/arrayaccess.offsetunset.php
	 *
	 * @param mixed $offset <p>
	 *                      The offset to unset.
	 *                      </p>
	 *
	 * @return void
	 * @since 5.0.0
	 */
	public function offsetUnset($offset) {
        unset($this->stats[$offset]);
	}

	/**
	 * Count elements of an object
	 *
	 * @link  http://php.net/manual/en/countable.count.php
	 * @return int The custom count as an integer.
	 * </p>
	 * <p>
	 * The return value is cast to an integer.
	 * @since 5.1.0
	 */
	public function count(): int {
		return count($this->stats);
	}

	private $pointer;

	/**
	 * Return the current element
	 *
	 * @link  http://php.net/manual/en/iterator.current.php
	 * @return mixed Can return any type.
	 * @since 5.0.0
	 */
	public function current() {
		return $this->stats[$this->pointer];
	}

	/**
	 * Move forward to next element
	 * @link  http://php.net/manual/en/iterator.next.php
	 * @return void Any returned value is ignored.
	 * @since 5.0.0
	 */
	public function next() {
		$this->pointer++;
	}

	/**
	 * Return the key of the current element
	 * @link  http://php.net/manual/en/iterator.key.php
	 * @return mixed scalar on success, or null on failure.
	 * @since 5.0.0
	 */
	public function key() {
		return $this->pointer;
	}

	/**
	 * Checks if current position is valid
	 * @link  http://php.net/manual/en/iterator.valid.php
	 * @return boolean The return value will be casted to boolean and then evaluated.
	 * Returns true on success or false on failure.
	 * @since 5.0.0
	 */
	public function valid() {
		return isset($this->stats[$this->pointer]);
	}

	/**
	 * Rewind the Iterator to the first element
	 * @link  http://php.net/manual/en/iterator.rewind.php
	 * @return void Any returned value is ignored.
	 * @since 5.0.0
	 */
	public function rewind() {
		$this->pointer = 0;
	}

	/**
	 * Specify data which should be serialized to JSON
	 *
	 * @link  http://php.net/manual/en/jsonserializable.jsonserialize.php
	 * @return mixed data which can be serialized by <b>json_encode</b>,
	 * which is a value of any type other than a resource.
	 * @since 5.4.0
	 */
	function jsonSerialize() {
		return [
			'region' => $this->region,
			'season' => $this->season,
			'matchMode' => $this->matchMode,
			'stats' => $this->stats
		];
	}
}