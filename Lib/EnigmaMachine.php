<?php

class EnigmaMachine {

	protected $_rotors = array();

	protected $_reflector = null;

	protected $_plugboard = null;

	public function addRotor($rotorType) {
		$this->_rotors[] = new EnigmaRotor($rotorType);

		return $this;
	}

	public function setReflector($reflectorType, $reflectorPosition) {
		$this->_reflector = new EnigmaReflector($reflectorType, $reflectorPosition);

		return $this;
	}

	public function setPlugboard($substitutions) {
		$this->_plugboard = new EnigmaPlugboard($substitutions);

		return $this;
	}

	public function setRotorPosition($startCode) {
		if (strlen($startCode) != count($this->_rotors)) {
			throw new Exception('Bad rotor position');
		}

		foreach($this->_rotors AS $key => $rotor) {
			$rotor->setPosition($startCode{$key});
		}

		return $this;
	}

	public function getRotorPosition() {
		$position = '';
		foreach ($this->_rotors AS $rotor) {
			$position .= $rotor->getPosition();
		}
		return $position;
	}

	public function input($message) {
		$output = '';

		$message = strtoupper($message);

		$messageLength = strlen($message);
		for ($index = 0; $index < $messageLength; $index++) {
			$character = $message{$index};

			$this->_rotateRotors();

			$character = $this->_plugboard->substitute($character);
			foreach (array_reverse($this->_rotors) AS $rotor) {
				$character = $rotor->encode($character);
			}
			$character = $this->_reflector->reflect($character);
			foreach ($this->_rotors AS $rotor) {
				$character = $rotor->decode($character);
			}
			$character = $this->_plugboard->substitute($character);

			$output .= $character;
		}

		return $output;
	}

	protected function _rotateRotors() {
		$rotations = str_repeat('0', count($this->_rotors));

		$rotateNext = true;
		foreach (array_reverse($this->_rotors) AS $index => $rotor) {
			if ($rotateNext) {
				$rotations{$index} = '1';
			}
			$rotateNext = $rotor->isTurnover();
		}

		$rotations = str_replace('101', '111', $rotations);

		foreach (array_reverse($this->_rotors) AS $index => $rotor) {
			if ($rotations{$index} == '1') {
				$rotor->rotate();
			}
		}
	}

}