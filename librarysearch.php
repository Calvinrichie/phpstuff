<?php

// Base class
class Book {
    protected $title;
    protected $author;
    protected $publicationYear;

    public function __construct($title, $author, $publicationYear) {
        $this->title = $title;
        $this->author = $author;
        $this->publicationYear = $publicationYear;
    }

    public function getDetails() {
        return "Title: {$this->title}, Author: {$this->author}, Year: {$this->publicationYear}";
    }
}

// Derived class for EBook
class EBook extends Book {
    private $fileSize; // in MB

    public function __construct($title, $author, $publicationYear, $fileSize) {
        parent::__construct($title, $author, $publicationYear);
        $this->fileSize = $fileSize;
    }

    public function getDetails() {
        return parent::getDetails() . ", File Size: {$this->fileSize}MB";
    }
}

// Derived class for PrintedBook
class PrintedBook extends Book {
    private $numberOfPages;

    public function __construct($title, $author, $publicationYear, $numberOfPages) {
        parent::__construct($title, $author, $publicationYear);
        $this->numberOfPages = $numberOfPages;
    }

    public function getDetails() {
        return parent::getDetails() . ", Pages: {$this->numberOfPages}";
    }
}

// Input reading and processing
$n = intval(trim(fgets(STDIN))); // Number of books
$books = [];

for ($i = 0; $i < $n; $i++) {
    $input = trim(fgets(STDIN));
    $parts = explode(" ", $input);
    $type = array_shift($parts);

    if ($type === 'EBook') {
        // Join title and author since they can contain spaces
        $title = trim(implode(" ", array_slice($parts, 0, -3)), '"');
        $author = trim(implode(" ", array_slice($parts, -3, 1)), '"');
        $publicationYear = intval($parts[-2]);
        $fileSize = intval($parts[-1]);
        $books[] = new EBook($title, $author, $publicationYear, $fileSize);
    } elseif ($type === 'PrintedBook') {
        $title = trim(implode(" ", array_slice($parts, 0, -3)), '"');
        $author = trim(implode(" ", array_slice($parts, -3, 1)), '"');
        $publicationYear = intval($parts[-2]);
        $numberOfPages = intval($parts[-1]);
        $books[] = new PrintedBook($title, $author, $publicationYear, $numberOfPages);
    }
}

$m = intval(trim(fgets(STDIN))); // Number of queries
for ($j = 0; $j < $m; $j++) {
    $queryIndex = intval(trim(fgets(STDIN))) - 1; // 1-based to 0-based
    if (isset($books[$queryIndex])) {
        echo $books[$queryIndex]->getDetails() . PHP_EOL;
    } else {
        echo "Book not found." . PHP_EOL;
    }
}
?>
