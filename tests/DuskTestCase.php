<?php

namespace Tests;

use Laravel\Dusk\Browser;
use Laravel\Dusk\TestCase as BaseTestCase;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;

abstract class DuskTestCase extends BaseTestCase
{
    use CreatesApplication, TestsHelper;

    /**
     * Prepare for Dusk test execution.
     *
     * @beforeClass
     * @return void
     */
    public static function prepare()
    {
        static::startChromeDriver();

        Browser::macro('assertSeeErrors', function (array $fields) {
            foreach ($fields as $name => $errors) {
                foreach ((array) $errors as $message) {
                    $this->assertSeeIn(
                        "#field_{$name}.has-error .help-block", $message
                    );
                }
            }
        });
    }

    /**
     * Create the RemoteWebDriver instance.
     *
     * @return \Facebook\WebDriver\Remote\RemoteWebDriver
     */
    protected function driver()
    {
        //Se cambio localhost por chrome que es el nombre del contenedor con el driver
        //Tambien se debe establecer la ip del contenedor web en el archivo: ".env.dusk" ej: APP_URL=http://172.18.0.2
        return RemoteWebDriver::create(
            'http://chrome:9515', DesiredCapabilities::chrome()
        );
    }
}
