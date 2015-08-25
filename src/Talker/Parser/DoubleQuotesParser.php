<?php
/**
 * Created by PhpStorm.
 * User: deus
 * Date: 24/08/15
 * Time: 23.10
 */

namespace Talker\Parser;

/**
 * Class DoubleQuotesParser.
 *
 * Parses the user input call string extracting element in double quotes.
 */
class DoubleQuotesParser implements ResourceParserInterface
{

    /**
     * @param string $string
     *
     * @return mixed
     * @throws \ErrorException
     */
    public function parse($string)
    {
        $quotePattern='/"(.*?)"/';
        preg_match_all($quotePattern, $string, $matches);
        if (empty($matches[1])) {
            throw new \ErrorException(sprintf("No parameters found, please check your string call: %s", $string));
        }

        return $matches[1];
    }
}