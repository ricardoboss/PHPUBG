<?php

namespace PHPUBG;

use PHPUBG\traits\HasDisplayString;
use PHPUBG\traits\IsUnique;

class Region implements \JsonSerializable {
	use IsUnique, HasDisplayString;

	const AGGREGATED = 0;
	const NORTH_AMERICA = 1;
	const EUROPE = 2;
	const ASIA = 3;
	const OCEANIA = 4;
	const SOUTH_AMERICA = 5;
	const SOUTH_EAST_ASIA = 6;

	/** @var string The unique identifier for this region. */
	protected $identifier;

	/**
	 * Region constructor.
	 *
	 * @param int    $id         The id of this region.
	 * @param string $identifier The unique identifier for this region.
	 * @param string $display    The string to be displayed for this region.
	 *
	 * @throws \InvalidArgumentException If a region with the specified id already exists.
	 */
	public function __construct(int $id, string $identifier, string $display) {
		$this->id = $id;
		$this->identifier = $identifier;
		$this->display = $display;

		self::add($this);

		if (is_null(self::$uniqueProperty))
			self::$uniqueProperty = "identifier";
	}

	/**
	 * @return string A string representation of this object.
	 */
	public function __toString(): string {
		return "[" . strtoupper($this->identifier) . "] {$this->display}";
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
			'id' => $this->id,
			'identifier' => $this->identifier,
			'display' => $this->display
		];
	}
}

new Region(Region::AGGREGATED, "agg", "Aggregated");
new Region(Region::NORTH_AMERICA, "na", "North America");
new Region(Region::EUROPE, "eu", "Europe");
new Region(Region::ASIA, "as", "Asia");
new Region(Region::OCEANIA, "oc", "Oceania");
new Region(Region::SOUTH_AMERICA, "sa", "South America");
new Region(Region::SOUTH_EAST_ASIA, "sea", "South East Asia");