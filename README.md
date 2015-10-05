# Eve-PHP Shade Template

Default File Structure for the Eve Framework

## Install PHPUnit

This is so you can run unit tests on your framework

```
curl -OL https://phar.phpunit.de/phpunit.phar

mv chmod +x phpunit.phar

mv phpunit.phar /usr/local/bin/phpunit

```

## Install PHP_Codesniffer

This is so you can be compliant to PSR-2

```
curl -OL https://squizlabs.github.io/PHP_CodeSniffer/phpcs.phar

mv chmod +x phpcs.phar

mv phpunit.phar /usr/local/bin/phpcs

```

## Install PHP_Codesniffer CBF

This is for autofixing PSR-2 violations

```
curl -OL https://squizlabs.github.io/PHP_CodeSniffer/phpcbf.phar

mv chmod +x phpcbf.phar

mv phpunit.phar /usr/local/bin/phpcbf

```

## Install Selenium Server

This is for selenium test support

```
curl -OL https://selenium-release.storage.googleapis.com/2.45/selenium-server-standalone-2.45.0.jar

mv selenium-server-standalone-2.45.0.jar ./selenium

java -jar selenium

```