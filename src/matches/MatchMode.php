<?php

namespace PHPUBG\matches;

use PHPUBG\traits\HasDisplayString;
use PHPUBG\traits\IsUnique;

class MatchMode implements \JsonSerializable {
	use IsUnique, HasDisplayString;

	const SOLO = 1;
	const DUO = 2;
	const SQUAD = 3;

	/** @var string The mode identifier. */
	protected $modeIdentifier;

	/**
	 * MatchMode constructor.
	 *
	 * @param int    $id             The id of this match mode.
	 * @param string $modeIdentifier The mode identifier.
	 * @param string $display        The display string for this match mode.
	 *
	 * @throws \InvalidArgumentException If a match mode with this id already exists.
	 */
	public function __construct(int $id, string $modeIdentifier, string $display) {
		$this->id = $id;
		$this->modeIdentifier = $modeIdentifier;
		$this->display = $display;

		self::add($this);

		if (is_null(self::$uniqueProperty))
			self::$uniqueProperty = "modeIdentifier";
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
			'identifier' => $this->modeIdentifier,
			'display' => $this->display
		];
	}
}

new MatchMode(MatchMode::SOLO, "solo", "Solo");
new MatchMode(MatchMode::DUO, "duo", "Duo");
new MatchMode(MatchMode::SQUAD, "squad", "Squad");