<?php

class EnigmaReflector extends EnigmaRotor {

	public function __construct($type, $position) {
		$settings = EnigmaSettings::fetch($type);

		$this->_substitutionKey = $settings['wiring'];
		$this->_position = 1;

		$this->setPosition($position);

		$this->_checkWiring();
	}

	public function reflect($character) {
		return $this->encode($character);
	}

	protected function _checkWiring() {
		foreach (range('A', 'Z') AS $char) {
			if ($char != $this->reflect($this->reflect($char))) {
				echo $char . ' ==> ' . $this->reflect($this->reflect($char));
				throw new Exception('Reflector wired incorrectly');
			}
		}
	}

}