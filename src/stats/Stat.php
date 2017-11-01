<?php

namespace PHPUBG\stats;

class Stat implements \JsonSerializable {
	/** @var null */
	protected $partition;

	/** @var string The label for this stat. */
	protected $label;

	/** @var null */
	protected $subLabel;

	/** @var string A machine-friendly label. */
	protected $field;

	/** @var StatCategory The category for this stat. */
	protected $category;

	/** @var int The integer representation of the value. */
	protected $valueInt;

	/** @var float The float representation of the value. */
	protected $valueDec;

	/** @var mixed The value of this stat. */
	protected $value;

	/** @var int The absolute rank of the player in this stat. */
	protected $rank;

	/** @var int The percent rank of the player in this stat. */
	protected $percentile;

	/** @var string The display string for this stat. */
	protected $displayValue;

	/**
	 * Stat constructor.
	 *
	 * @param $statArr array An array containing all data for a stat.
	 */
	public function __construct($statArr) {
		list(
			$this->label,
			$this->field,
			$this->category,
			$this->valueInt,
			$this->valueDec,
			$this->value,
			$this->rank,
			$this->percentile,
			$this->displayValue
		) = array_values($statArr);

		$this->category = StatCategory::findByProperty($this->category);
	}

	/**
	 * @return StatCategory The category for this stat.
	 */
	public function getCategory(): StatCategory {
		return $this->category;
	}

	/**
	 * @return string The display string for this stat.
	 */
	public function getDisplayValue(): string {
		return $this->displayValue;
	}

	/**
	 * @return string A machine-friendly label.
	 */
	public function getField(): string {
		return $this->field;
	}

	/**
	 * @return string The label for this stat.
	 */
	public function getLabel(): string {
		return $this->label;
	}

	/**
	 * @return null
	 */
	public function getPartition() {
		return $this->partition;
	}

	/**
	 * @return int The percent rank of the player in this stat.
	 */
	public function getPercentile(): int {
		return $this->percentile;
	}

	/**
	 * @return int The absolute rank of the player in this stat.
	 */
	public function getRank(): int {
		return $this->rank;
	}

	/**
	 * @return null
	 */
	public function getSubLabel() {
		return $this->subLabel;
	}

	/**
	 * @return mixed The value of this stat.
	 */
	public function getValue() {
		return $this->value;
	}

	/**
	 * @return float The float representation of the value.
	 */
	public function getValueDec(): float {
		return $this->valueDec;
	}

	/**
	 * @return int The integer representation of the value.
	 */
	public function getValueInt(): int {
		return $this->valueInt;
	}

	/**
	 * @return string A string representation for this stat.
	 */
	public function __toString(): string {
		return $this->label . ": " . $this->displayValue;
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
			'partition' => $this->partition,
			'label' => $this->label,
			'subLabel' => $this->subLabel,
			'field' => $this->field,
			'category' => $this->category,
			'valueInt' => $this->valueInt,
			'valueDec' => $this->valueDec,
			'value' => $this->value,
			'rank' => $this->rank,
			'percentile' => $this->percentile,
			'displayValue' => $this->displayValue
		];
	}
}