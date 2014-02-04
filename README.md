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

## Regex
There will be a regex check agains the number provided as argument
to this class. Override the function below to provide your own regex.

	protected static function numberRegex() {
		return "/\d{6}\s?-?\s?\d{3}\d?/";
	}

## License
Copyright 2013 Niklas Ekman, nikl.ekman@gmail.com

   Licensed under the Apache License, Version 2.0 (the "License");
   you may not use this file except in compliance with the License.
   You may obtain a copy of the License at

       http://www.apache.org/licenses/LICENSE-2.0

   Unless required by applicable law or agreed to in writing, software
   distributed under the License is distributed on an "AS IS" BASIS,
   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
   See the License for the specific language governing permissions and
   limitations under the License.