<?php

use PHPUBG\Communicator;
use PHPUBG\matches\MatchMode;
use PHPUBG\Player;
use PHPUBG\PubgBuilder;
use PHPUBG\Region;
use PHPUBG\Season;
use PHPUnit\Framework\TestCase;

class PubgBuilderTest extends TestCase {
	/**
	 * @return \PHPUBG\PubgBuilder
	 */
	public function testSetApiKey(): PubgBuilder {
		$builder = PubgBuilder::setApiKey("f61c06c0-cb80-4dab-9a54-53f14162c5ef");

		$this->assertEquals("f61c06c0-cb80-4dab-9a54-53f14162c5ef", Communicator::getApiKey());

		return $builder;
	}

	/**
	 * @depends testSetApiKey
	 *
	 * @param \PHPUBG\PubgBuilder $builder
	 *
	 * @return \PHPUBG\Player
	 * @throws \RuntimeException
	 */
	public function testGetPlayerByName(PubgBuilder $builder): Player {
		$player = $builder->getPlayer("MCMainiac");

		$this->assertEquals("MCMainiac", $player->getNickname());

		return $player;
	}

	/**
	 * @depends  testSetApiKey
	 * @depends  testGetPlayerByName
	 *
	 * @param \PHPUBG\PubgBuilder $builder
	 * @param \PHPUBG\Player      $playerByName
	 *
	 * @throws \RuntimeException
	 */
	public function testGetPlayerBySteamId(PubgBuilder $builder, Player $playerByName) {
		// using SteamID64 from MCMainiac
		$player = $builder->getPlayer(76561198128415640);

		$this->assertEquals("MCMainiac", $player->getNickname());
		$this->assertEquals($playerByName->getAccountId(), $player->getAccountId());
	}

	/**
	 * @depends testGetPlayerByName
	 *
	 * @param \PHPUBG\Player $player
	 *
	 * @throws \PHPUnit\Framework\Exception
	 */
	public function testFilterStats(Player $player) {
		$stats = $player->getStats();
		$this->assertGreaterThan(0, count($stats));

		$regionEurope = Region::get(Region::EUROPE);
		$seasonEA3 = Season::get(Season::EARLY_ACCESS_3);
		$modeSolo = MatchMode::get(MatchMode::SOLO);

		$statsEu = $player->getStats($regionEurope);
		foreach ($statsEu as $stat)
			$this->assertAttributeEquals($regionEurope, 'region', $stat);

		$statsEuEarly = $player->getStats($regionEurope, $seasonEA3);
		foreach ($statsEuEarly as $stat) {
			$this->assertAttributeEquals($regionEurope, 'region', $stat);
			$this->assertAttributeEquals($seasonEA3, 'season', $stat);
		}

		$statsEuEarlySolo = $player->getStats($regionEurope, $seasonEA3, $modeSolo);
		foreach ($statsEuEarlySolo as $stat) {
			$this->assertAttributeEquals($regionEurope, 'region', $stat);
			$this->assertAttributeEquals($seasonEA3, 'season', $stat);
			$this->assertAttributeEquals($modeSolo, 'matchMode', $stat);
		}
	}

	/**
	 * @depends testGetPlayerByName
	 *
	 * @param \PHPUBG\Player $player
	 */
	public function testJsonExport(Player $player) {
		$json = json_encode($player);

		$this->assertEquals(json_last_error(), JSON_ERROR_NONE);

		$playerArray = json_decode($json, true);

		$this->assertEquals(json_last_error(), JSON_ERROR_NONE);
		$this->assertEquals($playerArray['nickname'], $player->getNickname());
	}
}