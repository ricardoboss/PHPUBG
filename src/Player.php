<?php

namespace PHPUBG;

use PHPUBG\matches\MatchLiveTrackingEntry;
use PHPUBG\matches\MatchHistoryEntry;
use PHPUBG\matches\MatchMode;
use PHPUBG\stats\Stats;

class Player implements \JsonSerializable {
	/** @var int The id of the platform the player uses. */
	protected $platformId;

	/** @var string The account id of the player. */
	protected $accountId;

	/** @var string The url to the avatar of the player. */
	protected $avatarUrl;

	/** @var Region The selected region of the player. */
	protected $selectedRegion;

	/** @var Season The default season of the player. */
	protected $defaultSeason;

	/** @var int Unix timestamp of the last update. */
	protected $lastUpdated;

	/** @var array The last matches of the player. */
	protected $liveTracking = [];

	/** @var string The nickname used to retrieve information. */
	protected $nickname;

	/** @var int The PUBG Tracker id of the player. */
	protected $pubgTrackerId;

	/** @var array The stats of the player sorted by region, season and match mode. */
	protected $stats = [];

	/** @var array The match history of the player. */
	protected $matchHistory = [];

	/**
	 * Player constructor.
	 *
	 * @param $nickname string The nickname of the player
	 *
	 * @throws \RuntimeException If the data for the player cannot be received.
	 */
	public function __construct(string $nickname) {
		$this->nickname = $nickname;

		$this->retrieveData();
	}

	/**
	 * @throws \RuntimeException If the data could not be received.
	 */
	protected function retrieveData() {
		$data = Communicator::getData($this->nickname);

		list(
			$this->platformId,
			$this->accountId,
			$this->avatarUrl,
			$regionIdentifier,
			$seasonIdentifier,
			, // seasonDisplay
			$lastUpdated,
			, // PlayerName
			$this->pubgTrackerId,
			$statsArray/*,
			$liveTrackingArray,
			$matchHistoryArray*/
		) = array_values($data);

		$this->selectedRegion = Region::findByProperty($regionIdentifier);
		$this->defaultSeason = Season::findByProperty($seasonIdentifier);
		$this->lastUpdated = strtotime($lastUpdated);

		/*foreach ($liveTrackingArray as $liveTrackingMatchArray)
			$this->liveTracking[] = new MatchLiveTrackingEntry($liveTrackingMatchArray);*/

		foreach ($statsArray as $stats) {
			$region = Region::findByProperty($stats['Region']);
			if ($region === false)
				throw new \RuntimeException("Could not find region: " . $stats['Region']);

			$season = Season::findByProperty($stats['Season']);
			if ($season === false)
				throw new \RuntimeException("Could not find season: " . $stats['Season']);

			$matchMode = MatchMode::findByProperty($stats['Match']);
			if ($matchMode === false)
				throw new \RuntimeException("Could not find match mode: " . $stats['Match']);

			$regionId = $region->getId();
			$seasonId = $season->getId();
			$matchModeId = $matchMode->getId();

			$this->stats[$regionId][$seasonId][$matchModeId] = new Stats($region, $season, $matchMode, $stats['Stats']);
		}

		/*foreach ($matchHistoryArray as $matchHistoryEntryArray)
			$this->matchHistory[] = new MatchHistoryEntry($matchHistoryEntryArray);*/
	}

	/**
	 * Get the nickname of a player.
	 *
	 * @return string The nickname of the player.
	 */
	public function getNickname(): string {
		return $this->nickname;
	}

	/**
	 * Get the stats for a player by region, season an match mode.
	 *
	 * @param Region|null                    $region The region for the stats.
	 * @param Season|null                    $season The season for the stats.
	 * @param \PHPUBG\matches\MatchMode|null $mode   The mode for the stats.
	 *
	 * @return array|false An array containing Stats for the selected filters.
	 */
	public function getStats(Region $region = null, Season $season = null, MatchMode $mode = null): array {
		$regionSel = is_null($region) ? null : $region->getId();
		$seasonSel = is_null($season) ? null : $season->getId();
		$modeSel = is_null($mode) ? null : $mode->getId();

		$arr = [];

		foreach ($this->stats as $regionId => $regionStats) {
			if (!is_null($regionSel) && $regionSel != $regionId)
				continue;

			foreach ($regionStats as $seasonId => $seasonStats) {
				if (!is_null($seasonSel) && $seasonSel != $seasonId)
					continue;

				foreach ($seasonStats as $modeId => $stats) {
					if (!is_null($modeSel) && $modeSel != $modeId)
						continue;

					$arr[] = $stats;
				}
			}
		}

		return $arr;
	}

	/**
	 * @return string
	 */
	public function getAccountId(): string {
		return $this->accountId;
	}

	/**
	 * @return string
	 */
	public function getAvatarUrl(): string {
		return $this->avatarUrl;
	}

	/**
	 * @return Season
	 */
	public function getDefaultSeason(): Season {
		return $this->defaultSeason;
	}

	/**
	 * @return int
	 */
	public function getLastUpdated(): int {
		return $this->lastUpdated;
	}

	/**
	 * @return array
	 */
	public function getLiveTracking(): array {
		return $this->liveTracking;
	}

	/**
	 * @return array
	 */
	public function getMatchHistory(): array {
		return $this->matchHistory;
	}

	/**
	 * @return int
	 */
	public function getPlatformId(): int {
		return $this->platformId;
	}

	/**
	 * @return int
	 */
	public function getPubgTrackerId(): int {
		return $this->pubgTrackerId;
	}

	/**
	 * @return Region
	 */
	public function getSelectedRegion(): Region {
		return $this->selectedRegion;
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
			'platformId' => $this->platformId,
			'accountId' => $this->accountId,
			'avatarUrl' => $this->avatarUrl,
			'selectedRegion' => $this->selectedRegion,
			'defaultSeason' => $this->defaultSeason,
			'lastUpdated' => $this->lastUpdated,
			'liveTracking' => $this->liveTracking,
			'nickname' => $this->nickname,
			'pubgTrackerId' => $this->pubgTrackerId,
			'stats' => $this->stats,
			'matchHistory' => $this->matchHistory
		];
	}
}