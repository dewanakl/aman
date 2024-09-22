<p align="center"><img src="https://raw.githubusercontent.com/dewanakl/aman/main/img/aman.png" width="200" alt="aman"></p>

<p align="center">
<a href="https://php.net"><img src="https://img.shields.io/packagist/dependency-v/kamu/aman/php.svg" alt="PHP Programming Language"></a>
<a href="https://packagist.org/packages/kamu/aman"><img src="https://img.shields.io/packagist/dt/kamu/aman" alt="Total Downloads"></a>
<a href="https://github.com/dewanakl/aman"><img src="https://img.shields.io/github/repo-size/dewanakl/aman" alt="repo size"></a>
<a href="https://packagist.org/packages/kamu/aman"><img src="https://img.shields.io/packagist/v/kamu/aman" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/kamu/aman"><img src="https://img.shields.io/packagist/l/kamu/aman" alt="License"></a>
</p>

# Simple Profanity Filter with Regex

This is a simple project that filters out profane words using regex in PHP. It provides functions to check, filter, and remove unwanted words from a text using regex patterns that account for similar characters.

## Features

- **Profanity Check**: Check if a string contains any unwanted words.
- **Profanity Filter**: Remove unwanted words from a text.
- **Profanity Masking**: Replace unwanted words with a masking character, such as `*`.

## Installation

To install this package, you can use Composer:

1. Run the following command in your project directory:

   ```bash
   composer require kamu/aman
   ```

2. Add the list of words you want to filter in the db/lists.php file.

    ```php
    return [
        'badword1',
        'badword2',
        // Add more words you want to filter
    ];
    ```

## Usage

You can use the Aman class to filter profanity in your application.

### Example Usage

1. Check for Profane Words

    ```php
    use Kamu\Aman;

    $text = "This is an example with bad words.";
    $filter = Aman::factory();

    if ($filter->check($text)) {
        echo "This text contains profanity.";
    } else {
        echo "This text is clean.";
    }
    ```

2. Mask Profane Words

    ```php
    $text = "This is an example with bad words.";
    $maskedText = $filter->masking($text, '*');
    echo $maskedText; // Output: "This is an example with *** ****."
    ```

3. Remove Profane Words

    ```php
    $text = "This is an example with bad words.";
    $cleanText = $filter->filter($text);
    echo $cleanText; // Output: "This is an example with ."
    ```

4. Get Profane Words from Text

    ```php
    $text = "This is an example with bad words.";
    $badWords = $filter->words($text);
    print_r($badWords); // Output: ['bad', 'words']
    ```

## Contributing

I'm very open to those of you who want to contribute to the Aman!

## Security Vulnerabilities

If you find any security vulnerabilities in this Aman, please email DKL via [dewanakretarta29@gmail.com](mailto:dewanakretarta29@gmail.com).

## License

Aman is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
