<?php

class EnigmaPlugboard {

	protected $_substitutionMap = array();

	public function __construct(array $substitutions = array()) {
		foreach ($substitutions AS $from => $to) {
			$this->_substitutionMap[$from] = $to;
			$this->_substitutionMap[$to] = $from;
		}
	}

	public function substitute($character) {
		return !empty($this->_substitutionMap[$character]) ? $this->_substitutionMap[$character] : $character;
	}

}