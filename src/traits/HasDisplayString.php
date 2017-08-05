<?php

namespace PHPUBG\traits;

trait HasDisplayString {
	protected $display;

	public function getDisplay() {
		return $this->display;
	}

	public function __toString() {
		return $this->getDisplay();
	}
}