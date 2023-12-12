<?php

namespace App\DataFixtures;

use App\Entity\Auteur;
use App\Entity\Editeur;
use App\Entity\Genre;
use App\Entity\Livre;
use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private Generator $faker;
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->faker = Factory::create('fr_FR');
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $auteurs = [];
        $editeurs = [];
        $genres = [];
        for($i=0;$i<5;$i++)
        {
            $genre = new Genre();
            $genre->setNom("Genre".$i);
            $genres[$i]=$genre;
            $manager->persist($genre);
        }
        $count = 50;
        for($i=0;$i<$count;$i++)
        {
            //Utilisateurs
            $utilisateur = new Utilisateur();
            $utilisateur->setEmail($this->faker->email());
            $utilisateur->setImageName("defaultUser.jpg");
            $utilisateur->setNom($this->faker->lastName());
            $utilisateur->setPrenom($this->faker->firstName());
            $utilisateur->setPassword($this->hasher->hashPassword($utilisateur, "password"));
            $utilisateur->setRgpd(true);
            $manager->persist($utilisateur);

            //Auteurs
            $auteur = new Auteur();
            $auteur->setNom($this->faker->lastName());
            $auteur->setPrenom($this->faker->firstName());
            $manager->persist($auteur);

            //Editeurs
            $editeur = new Editeur();
            $editeur->setNom($this->faker->company());
            $manager->persist($editeur);

            $auteurs[$i] = $auteur;
            $editeurs[$i] = $editeur;
        }
        for($i=0;$i<50;$i++)
        {
            $livre = new Livre();
            $livre->setAuteur($auteurs[mt_rand(0,$count-1)]);
            $livre->setEditeur($editeurs[mt_rand(0, $count-1)]);
            $livre->setGenre($genres[mt_rand(0,count($genres)-1)]);
            $livre->setImageName("mcd.jpg");
            $livre->setQuantite(mt_rand(0,50));
            $livre->setResume($this->faker->paragraph());
            $livre->setTitre($this->faker->sentence(mt_rand(1,5)));
            $manager->persist($livre);
        }
        $manager->flush();
    }
}
