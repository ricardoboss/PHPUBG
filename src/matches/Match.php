<?php

namespace PHPUBG\matches;

use PHPUBG\Region;
use PHPUBG\Season;

class Match {
	/** @var MatchMode The match mode of this match. */
	protected $matchMode;

	/** @var Season The season of this match. */
	protected $season;

	/** @var Region The region of this match. */
	protected $region;

	/** @var int The date of this match. */
	protected $date;

	/** @var float The delta for this match. */
	protected $delta;

	/** @var float The value of this match. */
	protected $value;

	/** @var string The message for this match. */
	protected $message;

	public function __construct(array $matchArray) {
		list(
			$matchMode,
			, // MatchDisplay
			$seasonId,
			$regionId,
			$date,
			$this->delta,
			$this->value,
			$this->message
		) = $matchArray;

		$this->matchMode = MatchMode::get($matchMode);
		$this->season = Season::get($seasonId);
		$this->region = Region::get($regionId);
		$this->date = strtotime($date);
	}

	/**
	 * @return Region
	 */
	public function getRegion(): Region {
		return $this->region;
	}

	/**
	 * @return float
	 */
	public function getValue(): float {
		return $this->value;
	}

	/**
	 * @return int
	 */
	public function getDate(): int {
		return $this->date;
	}

	/**
	 * @return float
	 */
	public function getDelta(): float {
		return $this->delta;
	}

	/**
	 * @return MatchMode
	 */
	public function getMatchMode(): MatchMode {
		return $this->matchMode;
	}

	/**
	 * @return string
	 */
	public function getMessage(): string {
		return $this->message;
	}

	/**
	 * @return Season
	 */
	public function getSeason(): Season {
		return $this->season;
	}
}