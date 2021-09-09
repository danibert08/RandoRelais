 ->add('users', EntityType::class, [
                'by_reference' => false,
                'class' => User::class,
                'required'=>false,
                'multiple' => true,
                'attr' => ['size' => 10]
            ])
            Hello @ici :salut_main:
Parce que ça peut servir à tous je vous partage quelques commandes utiles lors d'une mise en prod, notamment pour la bdd ou les uploads.
Si vous avez besoin d'envoyer votre dossier d'uploads sur votre serveur distant :
Depuis votre machine locale :
tar -cvzf uploads.tar.gz uploads => compresse et créer un archive du dossier uploads
scp -i /chemin/vers/votre-cle.pem /chemin/vers/uploads.tar.gz ubuntu@ec2-XX-XXX-XX-XXX:/var/www/html/VOTREPROJET/public => permet d'envoyer un fichier sur le serveur distant dans /var/www/html/VOTREPROJET/public
Sur le serveur
Rendez vous à l'endroit ou vous avez envoyer le uploads.tar.gz
 tar -xvzf uploads.tar.gz  => décompresse le dossier uploads.tar.gz en uploads
Pour votre BDD
Faire un export via adminer
Faire la même chose qu'avec la commande scp  plus haut pour votre fichier sql exporté
Puis sur le serveur :flèche_bas:
mysql -uUserBdd -p nomBdd < fichier.sql => importe un fichier sql dans la bdd choisie (-uUserBdd  n'est pas une erreur, c'est bien collé)


php -S localhost:8000 -t public