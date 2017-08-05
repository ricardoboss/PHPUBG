<?php

namespace PHPUBG\traits;

trait HasId {
	/** @var mixed The unique identifier for this object. */
	protected $id;

	/**
	 * Get the id of this object.
	 *
	 * @return mixed The unique identifier of this object.
	 */
	public function getId() {
		return $this->id;
	}
}
