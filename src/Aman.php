<?php

namespace Kamu;

class Aman
{
    /**
     * Similar words.
     *
     * @var array<string, string> $similar
     */
    private $similar = [
        'a' => '(a|a\.|a\-|4|@|Á|á|À|Â|à|Â|â|Ä|ä|Ã|ã|Å|å|α|Δ|Λ|λ)',
        'b' => '(b|b\.|b\-|8|\|3|ß|Β|β)',
        'c' => '(c|c\.|c\-|Ç|ç|¢|€|<|\(|{|©)',
        'd' => '(d|d\.|d\-|&part;|\|\)|Þ|þ|Ð|ð)',
        'e' => '(e|e\.|e\-|3|€|È|è|É|é|Ê|ê|∑)',
        'f' => '(f|f\.|f\-|ƒ)',
        'g' => '(g|g\.|g\-|6|9)',
        'h' => '(h|h\.|h\-|Η)',
        'i' => '(i|i\.|i\-|!|\||\]\[|]|1|∫|Ì|Í|Î|Ï|ì|í|î|ï)',
        'j' => '(j|j\.|j\-)',
        'k' => '(k|k\.|k\-|Κ|κ)',
        'l' => '(l|1\.|l\-|!|\||\]\[|]|£|∫|Ì|Í|Î|Ï)',
        'm' => '(m|m\.|m\-)',
        'n' => '(n|n\.|n\-|η|Ν|Π)',
        'o' => '(o|o\.|o\-|0|Ο|ο|Φ|¤|°|ø)',
        'p' => '(p|p\.|p\-|ρ|Ρ|¶|þ)',
        'q' => '(q|q\.|q\-)',
        'r' => '(r|r\.|r\-|®)',
        's' => '(s|s\.|s\-|5|\$|§)',
        't' => '(t|t\.|t\-|Τ|τ)',
        'u' => '(u|u\.|u\-|υ|µ)',
        'v' => '(v|v\.|v\-|υ|ν)',
        'w' => '(w|w\.|w\-|ω|ψ|Ψ)',
        'x' => '(x|x\.|x\-|Χ|χ)',
        'y' => '(y|y\.|y\-|¥|γ|ÿ|ý|Ÿ|Ý)',
        'z' => '(z|z\.|z\-|Ζ)',
    ];

    /**
     * List of words.
     *
     * @var array<int, string> $lists
     */
    private $lists;

    /**
     * Singleton variable.
     *
     * @var Aman|null
     */
    public static $instance;

    /**
     * Init object.
     *
     * @return void
     */
    public function __construct()
    {
        $this->lists = [];
        $lists = (array) @require __DIR__ . '/db/lists.php';

        foreach ($lists as $list) {
            $this->lists[] = $this->getFilterRegexp($list);
        }
    }

    /**
     * From list to regex pattern.
     *
     * @param string $string
     * @return string
     */
    private function getFilterRegexp(string $string): string
    {
        $replace = str_ireplace(array_keys($this->similar), array_values($this->similar), $string);
        return '/' . $replace . '/iu';
    }

    /**
     * Create object.
     *
     * @return Aman
     */
    public static function factory(): Aman
    {
        if (!static::$instance) {
            static::$instance = new Aman();
        }

        return static::$instance;
    }

    /**
     * Check if contains.
     *
     * @param string $string
     * @return bool
     */
    public function check(string $string): bool
    {
        foreach ($this->lists as $pattern) {
            if (preg_match($pattern, $string)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Mask contains word.
     *
     * @param string $string
     * @param string $masking
     * @return string
     */
    public function masking(string $string, string $masking = '*'): string
    {
        return strval(preg_replace_callback($this->lists, function (array $words) use ($masking): string {
            return str_repeat($masking, strlen($words[0]));
        }, $string));
    }

    /**
     * Filter and remove if contains.
     *
     * @param string $string
     * @return string
     */
    public function filter(string $string): string
    {
        return strval(preg_replace_callback($this->lists, function (): string {
            return '';
        }, $string));
    }

    /**
     * Get from string.
     *
     * @param string $string
     * @return array<int, string>
     */
    public function words(string $string): array
    {
        $lists = [];
        preg_replace_callback($this->lists, function (array $words) use (&$lists): string {
            $lists[] = $words[0];
            return $words[0];
        }, $string);

        return $lists;
    }
}
