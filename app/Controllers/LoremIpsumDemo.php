<?php
namespace App\Controllers;

use App\Models\LoremIpsum;
use FastSitePHP\Application;
use FastSitePHP\Lang\I18N;

class LoremIpsumDemo
{
    /**
     * Route function for URL '/:lang/lorem-ipsum'
     * 
     * @param Application $app
     * @param string $lang
     * @return string
     */
    public function get(Application $app, $lang)
    {
        // Load JSON Language File
        I18N::langFile('lorem-ipsum', $lang);

        // Generate Test Records
        $records = $this->getData();
        $records = $records['records'];

        // Render a PHP Template and return the results
        return $app->render('lorem-ipsum.php', array(
            'nav_active_link' => 'lorem-ipsum',
            'records' => $records,
        ));
    }

    /**
     * Route function for URL '/:lang/lorem-ipsum/data' and also called
     * by the main function. Generates and returns sample data.
     * 
     * @return Array
     */
    public function getData()
    {
        // Create 20 Example Records
        $records = array();
        for ($n = 0; $n < 20; $n++) {
            // Generate a Random Number and Placeholder Text
            $value = rand(0, 1000);
            $text1 = LoremIpsum::text(10);
            $text2 = LoremIpsum::text();

            // Add sample data to the array
            $records[] = array(
                'text1' => $text1,
                'text2' => $text2,
                'value' => $value,
            );
        }

        // Return as Object
        return array(
            'records' => $records,
        );
    }
}