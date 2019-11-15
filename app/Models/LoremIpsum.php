<?php
namespace App\Models;

class LoremIpsum
{
    private static $place_holder_text = null;
    private static $text_count = null;

    /**
     * Generate Random Placeholder Text
     * 
     * @param int|null $max_length
     * @return string
     */
    public static function text($max_length = null)
    {
        // Load line-delimited file into memory first time function is called
        if (self::$place_holder_text === null) {
            // Read file
            $text = file_get_contents(__DIR__ . '/../../app_data/Lorem_ipsum.txt');
            // Normalize line endings [CRLF -> LF]
            $text = str_replace("\r\n", "\n", $text);
            // Split lines to an array
            self::$place_holder_text = explode("\n", $text);
            self::$text_count = count(self::$place_holder_text);
        }
        
        // Return a random string each time
        $text = self::$place_holder_text[rand(0, self::$text_count-1)];
        if ($max_length !== null) {
            $text = substr($text, 0, $max_length);
        }
        return $text;
    }
}