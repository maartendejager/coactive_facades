<?php

use Illuminate\Database\Seeder;
use App\Book;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('books')->delete();

        $book_gang_of_four = new Book([
                                          'title'       => 'Design Patterns: Elements of Reusable Object-Oriented Software',
                                          'description' => 'Capturing a wealth of experience about the design of object-oriented software, four top-notch designers present a catalog of simple and succinct solutions to commonly occurring design problems. Previously undocumented, these 23 patterns allow designers to create more flexible, elegant, and ultimately reusable designs without having to rediscover the design solutions themselve',
                                          'ISBN'        => '0201633612',
                                          'image'       => 'design_patterns.jpg',
                                          'stock'       => 10,
                                          'price'       => 54.95,
                                      ]);

        $book_gang_of_four->save();

        $book_head_first = new Book([
                                          'title'       => 'Head First Design Patterns',
                                          'description' => 'At any given moment, someone struggles with the same software design problems you have. And, chances are, someone else has already solved your problem. This edition of Head First Design Patterns—now updated for Java 8—shows you the tried-and-true, road-tested patterns used by developers to create functional, elegant, reusable, and flexible software. By the time you finish this book, you’ll be able to take advantage of the best design practices and experiences of those who have fought the beast of software design and triumphed.',
                                          'ISBN'        => '0596007124',
                                          'image'       => 'head_first.jpg',
                                          'stock'       => 10,
                                          'price'       => 54.95,
                                      ]);

        $book_head_first->save();
    }
}
