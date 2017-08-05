<?php

namespace PHPUBG\matches;

use PHPUBG\traits\HasDisplayString;
use PHPUBG\traits\IsUnique;

class MatchMode {
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
}

new MatchMode(MatchMode::SOLO, "solo", "Solo");
new MatchMode(MatchMode::DUO, "duo", "Duo");
new MatchMode(MatchMode::SQUAD, "squad", "Squad");