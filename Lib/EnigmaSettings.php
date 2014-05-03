<?php

class EnigmaSettings {

	protected static $_configFile = 'Config/Enigma.conf';

	protected static $_config = null;

	public static function fetch($configSetting) {
		if (is_null(self::$_config)) {
			self::load();
		}

		return isset(self::$_config[$configSetting]) ? self::$_config[$configSetting] : '';
	}

	protected static function load() {
		if (!is_file(self::$_configFile)) {
			throw new Exception('Config file not found');
		}

		self::$_config = json_decode(file_get_contents(self::$_configFile), true);

		if (is_null(self::$_config)) {
			throw new Exception('Config file invalid');
		}
	}

}