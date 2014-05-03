<?php

include 'Enigma.php';

$enigma = new EnigmaMachine();

$enigma->addRotor('I');
$enigma->addRotor('II');
$enigma->addRotor('III');

$enigma->setReflector('B', 1);

$enigma->setPlugboard(array(
	'A' => 'T',
	'S' => 'J',
));

echo $enigma->setRotorPosition('AAZ')->input('G');

$ciphertext = $enigma->setRotorPosition('OPE')->input('MYXSUPERXSECRETXMESSAGE');

echo '<br>';
echo '<br>';

$plaintext = $enigma->setRotorPosition('OPE')->input($ciphertext);

echo $plaintext;
