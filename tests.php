<?php

require "config/autoload.php";

//TEST de la BDD

class TestManager extends AbstractManager
{
    public function __construct()
    {
        parent::__construct();
        echo "TestManager instancié avec succès.";
    }
}

$testManager = new TestManager();



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
    "user",
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

$post->setId(4);



$comment1 = new Comment("Great post, very informative!", $user1, $post);
$comment2 =  new Comment("I totally agree with this point.", $user2, $post);
$comment3 =    new Comment("Looking forward to more articles!", $user1, $post);
$comment4 = new Comment("Thanks for the tips, very useful.", $user2, $post);



$post->addComment($comment1);
$post->addComment($comment2);
$post->addComment($comment3);
$post->addComment($comment4);


echo "<pre>";
var_dump("POST", $post);
echo "</pre>";



echo "<pre>";
var_dump("POST", $post);
echo "</pre>";



//TEST AJOUTER UN UTILISATEUR

// $userManager = new UserManager();
// $userManager->create($user2);
// echo "<pre>";
// var_dump("UTLISATEUR AJOUTE", $user2);
// echo "</pre>";

//TEST USer findOne()
$userManager = new UserManager();
$oneUserToFind = $userManager->findOne(31);
echo "<pre>";
var_dump("USER à TROUVER PAR ID", $oneUserToFind);
echo "</pre>";


// TEST findByEmail()

$userToFindByMail = $userManager->findByEmail("john.doe@example.com");
echo "<pre>";
var_dump("UTILISATEUR à TROUVER PAR MAIL", $userToFindByMail);
echo "</pre>";





//Test CATEGORIES

/// Création du CategoryManager
$categoryManager = new CategoryManager();

// Test findAll()
$categories = $categoryManager->findAll();
echo "<h2>Toutes les catégories:</h2>";
echo "<pre>";
var_dump($categories);
echo "</pre>";

// Test findOne()
$categoryToFind = $categoryManager->findOne(1); // Remplace 1 par l'ID de la catégorie que tu veux récupérer
echo "<h2>Catégorie à trouver par ID:</h2>";
echo "<pre>";
var_dump($categoryToFind);
echo "</pre>";


// TEST POST
$postManager = new PostManager();

// Test findLatest()
$latestPosts = $postManager->findLatest();
echo "<h2>Les 4 derniers posts:</h2>";
echo "<pre>";
foreach ($latestPosts as $post) {

    echo "Title: " . $post->getTitle() . "<br>";
    echo "Excerpt: " . $post->getExcerpt() . "<br>";
    // echo "Content: " . $post->getContent() . "<br>";
    echo "Author: " . $post->getAuthor()->getUsername() . "<br>";
    echo "Created At: " . $post->getCreatedAt()->format('Y-m-d H:i:s') . "<br>";
    echo "Category: " . $post->getCategory()->getTitle() . "<br>";

    echo "<hr>";
}
echo "</pre>";


// Test findOnes()

$postById = $postManager->findOne(1);
echo "<h2>Les post trouvé par son id</h2>";
echo "<pre>";
if ($postById) {
    echo "Id: " . $postById->getId() . "<br>";
    echo "Title: " . $postById->getTitle() . "<br>";
    echo "Excerpt: " . $postById->getExcerpt() . "<br>";
    // echo "Content: " . $postById->getContent() . "<br>";
    echo "Author: " . $postById->getAuthor()->getUsername() . "<br>";
    echo "Created At: " . $postById->getCreatedAt()->format('Y-m-d H:i:s') . "<br>";
    echo "Category: " . $postById->getCategory()->getTitle() . "<br>";

    echo "<hr>";
} else {
    echo "Aucun post trouvé avec cet ID.";
}

echo "</pre>";


//findByCategory(int $categoryId)

$postsByCategory = $postManager->findByCategory(1);
echo "<h2>Les posts trouvés par son Id de catégorie</h2>";
echo "<pre>";

if ($postsByCategory) {
    foreach ($postsByCategory as $post) {
        echo "Title: " . $post->getTitle() . "<br>";
        echo "Excerpt: " . $post->getExcerpt() . "<br>";
        // echo "Content: " . $post->getContent() . "<br>";
        echo "Author: " . $post->getAuthor()->getUsername() . "<br>";
        echo "Created At: " . $post->getCreatedAt()->format('Y-m-d H:i:s') . "<br>";
        echo "Category: " . $post->getCategory()->getTitle() . "<br>";

        echo "<hr>";
    }
} else {
    echo "Aucun post trouvé avec cet Id";
}



echo "</pre>";



// TEST COMMENTS

// findByPost(int $postId)

$commentManager = new CommentManager();
$commentsByPost = $commentManager->findByPost(1);
echo "<h2>Les commentaires trouvés par son Id de Post</h2>";
echo "<pre>";

if ($commentsByPost) {
    foreach ($commentsByPost as $comment) {
        echo "Comment: " . $comment->getContent() . "<br>";
        // echo "Excerpt: " . $comment->getExcerpt() . "<br>";
        // // echo "Content: " . $comment->getContent() . "<br>";
        // echo "Author: " . $comment->getAuthor()->getUsername() . "<br>";
        // echo "Created At: " . $comment->getCreatedAt()->format('Y-m-d H:i:s') . "<br>";
        // echo "Category: " . $comment->getCategory()->getTitle() . "<br>";

        echo "<hr>";
    }
} else {
    echo "Aucun commentaire trouvé avec cet Id";
}


// test create(Comment $comment)
//variable comment1 -> voir plus haut
$commentManager->create($comment4);
echo "<pre>";
var_dump("commentaire ajouté", $comment4->getContent());
echo "</pre>";
