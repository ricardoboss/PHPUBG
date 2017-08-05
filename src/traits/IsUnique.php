<?php

namespace PHPUBG\traits;

trait IsUnique {
	use HasId;

	/** @var array An associative array where the key is the id of an instance and the value is the instance itself. */
	protected static $instances = [];

	/** @var null|mixed A unique property from an instance to search for instances with a specific value for this property */
	protected static $uniqueProperty = null;

	/**
	 * Check whether an instance exists by checking for the id. Also checks for the unique property (if set).
	 *
	 * @param $id mixed The id or value of unique property to search for.
	 *
	 * @return bool True if an instance with this id or value for the unique property exists.
	 */
	public static function exists($id) {
		if (self::idExists($id))
			return true;

		if (self::uniquePropertyExists($id))
			return true;

		return false;
	}

	/**
	 * Check whether a specific id exists.
	 *
	 * @param $id mixed The id to search for.
	 *
	 * @return bool True if an instance with that id was found, false otherwise.
	 */
	private static function idExists($id) {
		return array_key_exists($id, self::$instances);
	}

	/**
	 * Check whether an instance has a specific value set for the unique property.
	 *
	 * @param $value mixed The value to check for.
	 *
	 * @return bool True if an instance was found, false otherwise.
	 */
	private static function uniquePropertyExists($value) {
		if (!is_null(self::$uniqueProperty))
			foreach (self::$instances as $instance)
				if ($instance->{self::$uniqueProperty} == $value)
					return true;

		return false;
	}

	/**
	 * Add an instance.
	 *
	 * @param $instance mixed The instance to add.
	 *
	 * @throws \InvalidArgumentException If an instance with the same id as the instance to be added already exists.
	 */
	protected function add($instance) {
		assert(method_exists($instance, "getId"), "Instance must use trait \"HasId\"");

		if (self::exists($instance->getId()))
			throw new \InvalidArgumentException("Instance with this id already exists: " . $instance->id);

		self::$instances[$instance->getId()] = $instance;
	}

	/**
	 * @return array All instances.
	 */
	public static function getAll() {
		return self::$instances;
	}

	/**
	 * Get a specific instance by it's id.
	 *
	 * @param $id mixed The id to search.
	 *
	 * @return false|mixed The instance with the specified id or false if no instance with that id exists.
	 */
	public static function get($id) {
		if (self::idExists($id))
			return self::$instances[$id];

		if (self::uniquePropertyExists($id))
			return self::findByProperty($id);

		return false;
	}

	/**
	 * Find an instance with a specific value for the unique property.
	 *
	 * @param $value mixed The value of the unique property to search for.
	 *
	 * @return false|mixed If found, the instance, false otherwise.
	 */
	public static function findByProperty($value) {
		if (is_null(self::$uniqueProperty))
			return false;

		foreach (self::$instances as $instance)
			if ($instance->{self::$uniqueProperty} == $value)
				return $instance;

		return false;
	}
}