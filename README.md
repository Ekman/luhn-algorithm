# Luhn Algorithm in PHP
This is an implementation of the Luhn Algorithm in PHP. The Luhn Algorithm is
used to validate things like credit cards and national identifcation numbers.
More information on the algorithm can be found at [Wikipedia](http://en.wikipedia.org/wiki/Luhn_algorithm)

## Usage
Use the class like this:

	$luhn = new LuhnAlgorithm('123456789');
	$luhn->isCompletelyValid();


The class contains some static functions as well. This will return the Luhn
checksum of a number:

	$number = '123456789';
	$luhnCheckSum = LuhnAlgorithm::calculateChecksum($number);

### Personnummer
If you'd like to validate the input to the class, extend it and do a regex check.
In the file **Personnummer.php**, I have extended the class to make sure that the
input is a valid Swedish national security id.