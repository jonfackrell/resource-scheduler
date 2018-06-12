<?php

namespace App\Models;


class RandomWord
{
    var $vowels = array('a','e','i','o','u');
    var $consonants = array('b','c','d','f','g','h','j','k','l','m','n','p','r','s','t','v','w','z','ch','qu','th','xy');
    var $word = '';

    /**
     * Constructor.
     *
     * @param  integer  Length of the word
     * @param  boolean  Return the word lowercase?
     * @param  boolean  Reutrn the word with the first letter capitalized?
     * @param  boolean  Return the word uppercase?
     * @return string
     */
    function generate($length = 5, $lower_case = true, $ucfirst = false, $upper_case = false)
    {
        $done = false;
        $const_or_vowel = 1;

        while (!$done)
        {
            switch ($const_or_vowel)
            {
                case 1:
                    $this->word .= $this->consonants[array_rand($this->consonants)];
                    $const_or_vowel = 2;
                    break;
                case 2:
                    $this->word .= $this->vowels[array_rand($this->vowels)];
                    $const_or_vowel = 1;
                    break;
            }

            if (strlen($this->word) >= $length)
            {
                $done = true;
            }
        }

        $this->word = substr($this->word, 0, $length);

        if ($lower_case)
        {
            $this->word = strtolower($this->word);
        }
        else if ($ucfirst)
        {
            $this->word = ucfirst(strtolower($this->word));
        }
        else if ($upper_case)
        {
            $this->word = strtoupper($this->word);
        }
        return $this->word;
    }
}