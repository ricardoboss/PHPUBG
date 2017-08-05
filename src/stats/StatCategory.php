<?php

namespace PHPUBG\stats;

use PHPUBG\traits\HasDisplayString;
use PHPUBG\traits\IsUnique;

class StatCategory {
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
}

new StatCategory(StatCategory::PERFORMANCE, "Performance");
new StatCategory(StatCategory::SKILL_RATING, "Skill Rating");
new StatCategory(StatCategory::PER_GAME, "Per Game");
new StatCategory(StatCategory::COMBAT, "Combat");
new StatCategory(StatCategory::SURVIVAL, "Survival");
new StatCategory(StatCategory::DISTANCE, "Distance");
new StatCategory(StatCategory::SUPPORT, "Support");