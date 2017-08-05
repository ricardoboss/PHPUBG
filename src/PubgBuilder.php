<?php

namespace PHPUBG;

class PubgBuilder {
	/**
	 * Set the api key used to communicate with the api.
	 *
	 * @param $apiKey string Your TRN API key.
	 *
	 * @return \PHPUBG\PubgBuilder An instance of the builder.
	 */
	public static function setApiKey(string $apiKey): PubgBuilder {
		return new PubgBuilder($apiKey);
	}

	/**
	 * PubgBuilder constructor.
	 *
	 * @param $apiKey string The api key used to authenticate api requests.
	 */
	private function __construct(string $apiKey) {
		Communicator::setApiKey($apiKey);
	}

	/**
	 * Get a player by their nickname or their steam id.
	 *
	 * @param $nameOrId string|int The name of the player or their steam id (64 bit number).
	 *
	 * @return \PHPUBG\Player A PUBG player.
	 * @throws \RuntimeException If the steam id cannot be resolved into a nickname.
	 */
	public function getPlayer($nameOrId): Player {
		// check if a steam id or a username has been provided
		if (is_int($nameOrId)) {
			$name = Communicator::resolveSteamId($nameOrId);
		} else
			$name = $nameOrId;

		return new Player($name);
	}
}