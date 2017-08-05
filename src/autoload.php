<?php
spl_autoload_register(function (string $className): bool {
	// split namespace into directory separators and add ".php" suffix
	$classFile = __DIR__ . "/" . str_replace("\\", "/", str_replace("PHPUBG\\", "", $className)) . ".php";

	if (file_exists($classFile)) {
		/** @noinspection PhpIncludeInspection */
		require($classFile);

		return true;
	} else
		return false;
}, true, false);