<?php

namespace PHPUBG\stats;

use PHPUBG\traits\HasDisplayString;
use PHPUBG\traits\IsUnique;

class StatCategory implements \JsonSerializable {
	use IsUnique, HasDisplayString;

	public const PERFORMANCE = 0;
	public const SKILL_RATING = 1;
	public const PER_GAME = 2;
	public const COMBAT = 3;
	public const SURVIVAL = 4;
	public const DISTANCE = 5;
	public const SUPPORT = 6;

	/**
	 * StatCategory constructor.
	 *
	 * @param $id      int    The id of the stat category.
	 * @param $display string The string being displayed.
	 *
	 * @throws \InvalidArgumentException If the id already exists.
	 */
	public function __construct(int $id, string $display) {
		$this->id = $id;
		$this->display = $display;

		self::add($this);

		if (is_null(self::$uniqueProperty))
			self::$uniqueProperty = "display";
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
			'display' => $this->display
		];
	}
}

new StatCategory(StatCategory::PERFORMANCE, "Performance");
new StatCategory(StatCategory::SKILL_RATING, "Skill Rating");
new StatCategory(StatCategory::PER_GAME, "Per Game");
new StatCategory(StatCategory::COMBAT, "Combat");
new StatCategory(StatCategory::SURVIVAL, "Survival");
new StatCategory(StatCategory::DISTANCE, "Distance");
new StatCategory(StatCategory::SUPPORT, "Support");