<?php

namespace PHPUBG;

class Communicator {
	/** @var string The basic url for the pubgtracker api. */
	public const URL_BASE = "https://pubgtracker.com/api";

	/** @var string The url for retrieving statistics via the username. */
	public const URL_NAME = self::URL_BASE . "/profile/pc/";

	/** @var string The url for finding the nickname via the steam id. */
	public const URL_STEAM_ID = self::URL_BASE . "/search?steamId=";

	/** @var string The api key to use when communicating with the api. */
	protected static $apiKey;

	/**
	 * Set the api key to use when communicating with the api.
	 *
	 * @param string $apiKey The api key to use.
	 */
	public static function setApiKey(string $apiKey) {
		self::$apiKey = $apiKey;
	}

	/**
	 * Get the api key set while creating the PubgBuilder instance.
	 *
	 * @return string The api key used to authenticate api requests.
	 */
	public static function getApiKey(): string {
		return self::$apiKey;
	}

	/**
	 * Resolves the steam id to a nickname.
	 *
	 * @param int $steamId The steam id.
	 *
	 * @return string The nickname of the user.
	 * @throws \RuntimeException If an invalid response has been received.
	 */
	public static function resolveSteamId(int $steamId): string {
		$url = self::URL_STEAM_ID . $steamId;
		$response = self::getJson($url);

		if (is_null($response))
			throw new \RuntimeException("Cannot resolve steam id: $steamId\n" . json_last_error_msg());
		else if (!array_key_exists('Nickname', $response))
			throw new \RuntimeException("Response does not contain \"Nickname\" key!");

		return $response['Nickname'];
	}

	/**
	 * Get all data for a player by their nickname.
	 *
	 * @param string $nickname The nickname.
	 *
	 * @return array An associative array containing all stats.
	 * @throws \RuntimeException
	 */
	public static function getData(string $nickname): array {
		$url = self::URL_NAME . $nickname;
		$response = self::getJson($url);

		if (is_null($response))
			throw new \RuntimeException("Cannot retrieve stats for nickname: $nickname\nGot an invalid response.");

		return $response;
	}

	/**
	 * Get a json response from a specific url.
	 *
	 * @param string $url The url to send the request to.
	 *
	 * @return array|null An associative array or null if the response if not properly formatted.
	 * @throws \RuntimeException If the request fails.
	 */
	private static function getJson(string $url) {
		if (is_null(self::$apiKey))
			throw new \RuntimeException("API key is not set!");

		$ch = curl_init();

		curl_setopt_array($ch, [
			CURLOPT_HTTPHEADER => self::build_http_headers([
				"TRN-Api-Key" => self::$apiKey,
				"Accept" => "application/json"
			]),
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_URL => $url,
			CURLOPT_SSL_VERIFYHOST => false,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_1
		]);

		$jsonResponse = curl_exec($ch);

		if ($jsonResponse === false)
			throw new \RuntimeException("Request to \"$url\" failed!\n" . curl_error($ch));

		curl_close($ch);

		return json_decode($jsonResponse, true);
	}

	/**
	 * Concatenates the keys of an associative array to the values like this: "{key}: {value}".
	 *
	 * @param array $headers An associative array.
	 *
	 * @return array The combined headers.
	 */
	private static function build_http_headers(array $headers): array {
		$combinedHeaders = [];

		foreach ($headers as $header => $value)
			$combinedHeaders[] = $header . ": " . $value;

		return $combinedHeaders;
	}
}