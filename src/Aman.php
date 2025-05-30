<?php

namespace Kamu;

class Aman
{
    /**
     * Similar words.
     *
     * @var array<string, string> $similar
     */
    public const similar = [
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
        'n' => '(n|n\.|n\-|η|Ν|Π|ñ)',
        'o' => '(o|o\.|o\-|0|Ο|ο|Φ|¤|°|ø|ö|ó)',
        'p' => '(p|p\.|p\-|ρ|Ρ|¶|þ)',
        'q' => '(q|q\.|q\-)',
        'r' => '(r|r\.|r\-|®)',
        's' => '(s|s\.|s\-|5|\$|§)',
        't' => '(t|t\.|t\-|Τ|τ)',
        'u' => '(u|u\.|u\-|υ|µ|ü|ù)',
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
    private array $lists;

    /**
     * Singleton variable.
     *
     * @var Aman|null
     */
    public static ?Aman $instance = null;

    /**
     * Whitelist items.
     *
     * @var array<int, string>
     */
    public static array $whiteList = [];

    /**
     * Extended items.
     *
     * @var array<int, string>
     */
    public static array $blockList = [];

    /**
     * Init object.
     *
     * @return void
     */
    public function __construct()
    {
        $db = (array) require __DIR__ . '/db/lists.php';
        $lists = array_diff(array_unique(array_merge($db, static::$blockList)), array_unique(static::$whiteList));

        $this->lists = array_values(array_map(function (string $str): string {

            $replace = strval(preg_replace_callback('/[a-z]/i', function (array $matches): string {
                return strval(static::similar[strtolower($matches[0])] ?? $matches[0]);
            }, $str));

            return '/\b' . $replace . '\b/iu';
        }, $lists));
    }

    /**
     * Set the allowlist of items.
     *
     * @param array<int, string> $data
     * @return void
     */
    public static function allow(array $data): void
    {
        static::$whiteList = array_merge(static::$whiteList, $data);
    }

    /**
     * Set the extended blocklist of items.
     *
     * @param array<int, string> $data
     * @return void
     */
    public static function extend(array $data): void
    {
        static::$blockList = array_merge(static::$blockList, $data);
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
