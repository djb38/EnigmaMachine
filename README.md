Currently the rotor rotation is wonky, so reflectors won't work in any but the 'A' position, and ciphertext will deviate from real Enigma output. However, it's internally consistent, so ciphertext decodes to plaintext correctly.

- Steckering is implemented
- Double-stepping is implemented.
- Choice and ordering of rotors, as well as choice of reflector is implemented. The most common historical examples are provided, config file is JSON to easily add more.