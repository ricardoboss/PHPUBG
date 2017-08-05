<?php

namespace PHPUBG\matches;

use PHPUBG\Region;
use PHPUBG\Season;
use PHPUBG\traits\HasId;

class MatchHistoryEntry implements \JsonSerializable {
	use HasId;

	/** @var int Unix timestamp of the last update. */
	protected $updated;

	/** @var Season The season of the match(es). */
	protected $season;

	/** @var MatchMode The match mode of the match(es). */
	protected $matchMode;

	/** @var Region The region of the match(es). */
	protected $region;

	/** @var int The amount of rounds played. */
	protected $rounds;

	/** @var int The amount of wins. */
	protected $wins;

	/** @var int The amount of kills. */
	protected $kills;

	/** @var int The amount of assists. */
	protected $assists;

	/** @var int How often the player got to the top 10 survivors. */
	protected $top10;

	/** @var float The rating of the player. */
	protected $rating;

	/** @var float The change of the rating. */
	protected $ratingChange;

	/** @var int The rating rank of the player. */
	protected $ratingRank;

	/** @var int The change of the rating rank of the player. */
	protected $ratingRankChange;

	/** @var  int The amount of headshots. */
	protected $headshots;

	/** @var float The kill-death-ratio of the player. */
	protected $kd;

	/** @var int The damage dealt by the player. */
	protected $damage;

	/** @var float The amount of seconds the player survived. */
	protected $timeSurvived;

	/** @var float The distance in meters the player has travelled. */
	protected $moveDistance;

	public function __construct(array $matchArray) {
		list(
			$this->id,
			$updated,
			, // UpdatedJS
			$seasonId,
			, // SeasonDisplay
			$matchModeId,
			, // MatchDisplay
			$regionId,
			, // RegionDisplay
			$this->rounds,
			$this->wins,
			$this->kills,
			$this->assists,
			$this->top10,
			$this->rating,
			$this->ratingChange,
			$this->ratingRank,
			$this->ratingRankChange,
			$this->headshots,
			$this->kd,
			$this->damage,
			$this->timeSurvived,
			$this->moveDistance
		) = array_values($matchArray);

		$this->updated = strtotime($updated);
		$this->season = Season::get($seasonId);
		$this->matchMode = MatchMode::get($matchModeId);
		$this->region = Region::get($regionId);
	}

	/**
	 * @return int
	 */
	public function getAssists(): int {
		return $this->assists;
	}

	/**
	 * @return int
	 */
	public function getDamage(): int {
		return $this->damage;
	}

	/**
	 * @return int
	 */
	public function getHeadshots(): int {
		return $this->headshots;
	}

	/**
	 * @return float
	 */
	public function getKd(): float {
		return $this->kd;
	}

	/**
	 * @return int
	 */
	public function getKills(): int {
		return $this->kills;
	}

	/**
	 * @return MatchMode
	 */
	public function getMatchMode(): MatchMode {
		return $this->matchMode;
	}

	/**
	 * @return float
	 */
	public function getMoveDistance(): float {
		return $this->moveDistance;
	}

	/**
	 * @return float
	 */
	public function getRating(): float {
		return $this->rating;
	}

	/**
	 * @return float
	 */
	public function getRatingChange(): float {
		return $this->ratingChange;
	}

	/**
	 * @return int
	 */
	public function getRatingRank(): int {
		return $this->ratingRank;
	}

	/**
	 * @return int
	 */
	public function getRatingRankChange(): int {
		return $this->ratingRankChange;
	}

	/**
	 * @return Region
	 */
	public function getRegion(): Region {
		return $this->region;
	}

	/**
	 * @return int
	 */
	public function getRounds(): int {
		return $this->rounds;
	}

	/**
	 * @return Season
	 */
	public function getSeason(): Season {
		return $this->season;
	}

	/**
	 * @return float
	 */
	public function getTimeSurvived(): float {
		return $this->timeSurvived;
	}

	/**
	 * @return int
	 */
	public function getTop10(): int {
		return $this->top10;
	}

	/**
	 * @return int
	 */
	public function getUpdated(): int {
		return $this->updated;
	}

	/**
	 * @return int
	 */
	public function getWins(): int {
		return $this->wins;
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
			'updated' => $this->updated,
			'season' => $this->season,
			'matchMode' => $this->matchMode,
			'region' => $this->region,
			'rounds' => $this->rounds,
			'wins' => $this->wins,
			'kills' => $this->kills,
			'assists' => $this->assists,
			'top10' => $this->top10,
			'rating' => $this->rating,
			'ratingChange' => $this->ratingChange,
			'ratingRank' => $this->ratingRank,
			'ratingRankChange' => $this->ratingRankChange,
			'headshots' => $this->headshots,
			'kd' => $this->kd,
			'damage' => $this->damage,
			'timeSurvived' => $this->timeSurvived,
			'moveDistance' => $this->moveDistance
		];
	}
}