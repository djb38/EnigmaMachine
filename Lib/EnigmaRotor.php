<?php

class EnigmaRotor {

	protected $_substitutionKey = '';

	protected $_position = null;

	protected $_turnoverPositions = null;

	public function __construct($type) {
		$settings = EnigmaSettings::fetch($type);

		$this->_substitutionKey = $settings['wiring'];
		$this->_position = 1;
		$this->_turnoverPositions = $settings['notches'];
	}

	public function setPosition($position) {
		if (!is_numeric($position)) {
			$position = $this->_charToInt($position);
		}

		while ($this->_position != $position) {
			$this->rotate();
		}
	}

	public function getPosition() {
		return $this->_intToChar($this->_position);
	}

	public function isTurnover() {
		return in_array($this->_intToChar($this->_position), $this->_turnoverPositions);
	}

	public function encode($character) {
		$characterIndex = $this->_charToInt($character) - 1;
		return !empty($this->_substitutionKey{$characterIndex}) ? $this->_substitutionKey{$characterIndex} : $character;
	}

	public function decode($character) {
		$characterIndex = strpos($this->_substitutionKey, $character);
		if ($characterIndex === false) {
			return $character;
		}
		
		$characterIndex += 1;
		return $this->_intToChar($characterIndex);
	}

	public function rotate() {
		$this->_substitutionKey = substr($this->_substitutionKey, 1) . $this->_substitutionKey{0};
		$this->_position = ($this->_position % 26) + 1;
	}

	protected function _charToInt($char) {
		return ord(strtolower($char)) - 96;
	}

	protected function _intToChar($int) {
		return strtoupper(chr($int + 96));
	}

}