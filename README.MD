<p align="center"><img src="https://raw.githubusercontent.com/dewanakl/aman/main/img/aman.png" width="200" alt="aman"></p>

<p align="center">
<a href="https://php.net"><img src="https://img.shields.io/packagist/dependency-v/kamu/aman/php.svg?color=birghtgreen" alt="PHP Programming Language"></a>
<a href="https://packagist.org/packages/kamu/aman"><img src="https://img.shields.io/packagist/dt/kamu/aman" alt="Total Downloads"></a>
<a href="https://cie.my.id"><img src="https://cie.my.id/aman?label=views&color=brightgreen" alt="views"></a>
<a href="https://shields.io"><img src="https://img.shields.io/github/repo-size/dewanakl/aman?color=brightgreen" alt="Repo size"></a>
<a href="https://packagist.org/packages/kamu/aman"><img src="https://img.shields.io/packagist/l/kamu/aman?color=birghtgreen" alt="License"></a>
</p>

# 🤬 Simple Profanity Filter

This is a simple project that filters out profane words using regex in PHP. It provides functions to check, get, mask, and remove unwanted words from a text using regex patterns that account for similar characters.

## 📦 Installation

1. Run the following command in your project directory:

   ```bash
   composer require kamu/aman
   ```

2. How to Add Blocklist or Allowlist Words

    ```php
    // Add words to the blocklist
    Aman::extend(['oke', 'safe']);

    // Add words to the whitelist
    Aman::allow(['oke', 'safe']);
    ```

## 🛠️ Usage

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

## 🤝 Contributing

I'm very open to those of you who want to contribute to the Aman!

## 🐞 Security Vulnerabilities

If you find any security vulnerabilities in this Aman, please email DKL via [dewanakretarta29@gmail.com](mailto:dewanakretarta29@gmail.com).

## 📜 License

Aman is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
