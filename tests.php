<?php

require "config/autoload.php";

//TESTS DES INSTANCES


// test User

$user1 = new User(
    "john_doe",
    "john.doe@example.com",
    "password123",
    "admin",
    new DateTime("2023-01-01 12:00:00")
);

$user1->setId(1);


echo "<pre>";
var_dump("USER", $user1);
echo "</pre>";

$user2 = new User(
    "jane_smith",
    "jane.smith@example.com",
    "mypassword456",
    "editor",
    new DateTime("2023-05-15 09:30:00")
);


$user2->setId(2);


// test Category


$category = new Category(
    "Tech",
    "All about tech news and updates"
);


echo "<pre>";
var_dump("CATEGORIE", $category);
echo "</pre>";



//test Post

$post = new Post(
    "My first tech post",
    "This is a short excerpt",
    "This is the full content of the post",
    $user1,
    new DateTime(),
    $category
);

$post->setId(1);



$comment1 = new Comment("Great post, very informative!", $user1->getId(), $post->getId(), $post);
$comment2 =  new Comment("I totally agree with this point.", $user2->getId(), $post->getId(), $post);
$comment3 =    new Comment("Looking forward to more articles!", $user1->getId(), $post->getId(), $post);
$comment4 = new Comment("Thanks for the tips, very useful.", $user2->getId(), $post->getId(), $post);



$post->addComment($comment1);
$post->addComment($comment2);
$post->addComment($comment3);
$post->addComment($comment4);

// Affichage de l'objet Post avec var_dump
echo "<pre>";
var_dump("POST", $post);
echo "</pre>";



echo "<pre>";
var_dump("POST", $post);
echo "</pre>";
