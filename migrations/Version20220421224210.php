<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220421224210 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE arbitre (id INT AUTO_INCREMENT NOT NULL, id_role INT DEFAULT NULL, nom VARCHAR(100) NOT NULL, prenom VARCHAR(100) NOT NULL, image VARCHAR(100) NOT NULL, age INT NOT NULL, email VARCHAR(100) NOT NULL, INDEX id_role (id_role), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE avis (id_avis INT AUTO_INCREMENT NOT NULL, id_produit INT DEFAULT NULL, id_user INT DEFAULT NULL, avis DOUBLE PRECISION NOT NULL, INDEX fk_user (id_user), INDEX fk_avis (id_produit), PRIMARY KEY(id_avis)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE billet (id INT AUTO_INCREMENT NOT NULL, id_match INT DEFAULT NULL, id_user INT DEFAULT NULL, bloc VARCHAR(500) NOT NULL, prix DOUBLE PRECISION NOT NULL, INDEX user_fk (id_user), INDEX forien_key (id_match), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classment (id_classment INT AUTO_INCREMENT NOT NULL, id_equipe INT DEFAULT NULL, nb_totale_but INT NOT NULL, nb_totale_but_recu INT NOT NULL, nb_point INT NOT NULL, saison VARCHAR(8) NOT NULL, nb_win INT NOT NULL, nb_draw INT NOT NULL, nb_lose INT NOT NULL, INDEX equipe_classment (id_equipe), PRIMARY KEY(id_classment)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipe (id INT AUTO_INCREMENT NOT NULL, nomeq VARCHAR(100) NOT NULL, logo VARCHAR(100) NOT NULL, nom_entreneur VARCHAR(100) NOT NULL, niveau VARCHAR(100) NOT NULL, stade VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE joueur (id INT AUTO_INCREMENT NOT NULL, id_equipe INT DEFAULT NULL, nom VARCHAR(100) NOT NULL, prenom VARCHAR(100) NOT NULL, poste VARCHAR(100) NOT NULL, nationalite VARCHAR(100) NOT NULL, date_naiss DATE NOT NULL, taille DOUBLE PRECISION NOT NULL, poids DOUBLE PRECISION NOT NULL, image VARCHAR(200) NOT NULL, INDEX id_equipe (id_equipe), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE matchjoueur (id INT AUTO_INCREMENT NOT NULL, id_joueur INT DEFAULT NULL, id_match INT DEFAULT NULL, carton_jaune INT NOT NULL, carton_rouge INT NOT NULL, nb_but INT NOT NULL, INDEX id_match (id_match), INDEX id_joueur (id_joueur), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE matchs (id INT AUTO_INCREMENT NOT NULL, id_arbitre4 INT DEFAULT NULL, equipe2 INT DEFAULT NULL, id_arbitre1 INT DEFAULT NULL, id_arbitre3 INT DEFAULT NULL, equipe1 INT DEFAULT NULL, id_arbitre2 INT DEFAULT NULL, nb_but1 INT NOT NULL, nb_but2 INT NOT NULL, stade VARCHAR(100) NOT NULL, date DATETIME NOT NULL, nb_spectateur INT NOT NULL, saison VARCHAR(8) NOT NULL, round INT NOT NULL, INDEX equipe_FK1 (equipe1), INDEX arbitre_FK3 (id_arbitre3), INDEX equipe_FK2 (equipe2), INDEX arbitre_FK4 (id_arbitre4), INDEX arbitre_FK1 (id_arbitre1), INDEX arbitre_FK2 (id_arbitre2), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_items (id INT AUTO_INCREMENT NOT NULL, order_id INT DEFAULT NULL, product_id INT NOT NULL, quantity INT NOT NULL, INDEX order_items_ibfk_1 (order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE orders (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, state VARCHAR(20) DEFAULT \'pending\' NOT NULL, date DATE NOT NULL, INDEX order_user_FK (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, id_cat INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, image VARCHAR(500) NOT NULL, prix DOUBLE PRECISION NOT NULL, description VARCHAR(1000) NOT NULL, stock INT NOT NULL, code INT NOT NULL, INDEX fk (id_cat), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role_arbitre (id INT AUTO_INCREMENT NOT NULL, role VARCHAR(100) NOT NULL, description VARCHAR(500) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE taille (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(500) NOT NULL, id_produit INT NOT NULL, stock INT NOT NULL, INDEX fx_produit (id_produit), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transfert (id INT AUTO_INCREMENT NOT NULL, id_ancieneq INT DEFAULT NULL, id_joueur INT DEFAULT NULL, id_nouveaueq INT DEFAULT NULL, INDEX id_nouveaueq (id_nouveaueq), INDEX id_joueur (id_joueur), INDEX id_ancieneq (id_ancieneq), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, prenom VARCHAR(100) NOT NULL, email VARCHAR(100) NOT NULL, pass VARCHAR(100) NOT NULL, tel INT NOT NULL, ban TINYINT(1) NOT NULL, block DATE DEFAULT NULL, forgetpassCode VARCHAR(50) DEFAULT NULL, role VARCHAR(50) DEFAULT \'user\' NOT NULL, UNIQUE INDEX email (email), UNIQUE INDEX t_unique (tel), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wishlist (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_9CE12A31A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wishlist_produit (wishlist_id INT NOT NULL, produit_id INT NOT NULL, INDEX IDX_B6A93A5DFB8E54CD (wishlist_id), INDEX IDX_B6A93A5DF347EFB (produit_id), PRIMARY KEY(wishlist_id, produit_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE arbitre ADD CONSTRAINT FK_20B2E66EDC499668 FOREIGN KEY (id_role) REFERENCES role_arbitre (id)');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF0F7384557 FOREIGN KEY (id_produit) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF06B3CA4B FOREIGN KEY (id_user) REFERENCES user (id)');
        $this->addSql('ALTER TABLE billet ADD CONSTRAINT FK_1F034AF694DE8435 FOREIGN KEY (id_match) REFERENCES matchs (id)');
        $this->addSql('ALTER TABLE billet ADD CONSTRAINT FK_1F034AF66B3CA4B FOREIGN KEY (id_user) REFERENCES user (id)');
        $this->addSql('ALTER TABLE classment ADD CONSTRAINT FK_31E06B0327E0FF8 FOREIGN KEY (id_equipe) REFERENCES equipe (id)');
        $this->addSql('ALTER TABLE joueur ADD CONSTRAINT FK_FD71A9C527E0FF8 FOREIGN KEY (id_equipe) REFERENCES equipe (id)');
        $this->addSql('ALTER TABLE matchjoueur ADD CONSTRAINT FK_C9233AF8DB461C28 FOREIGN KEY (id_joueur) REFERENCES joueur (id)');
        $this->addSql('ALTER TABLE matchjoueur ADD CONSTRAINT FK_C9233AF894DE8435 FOREIGN KEY (id_match) REFERENCES matchs (id)');
        $this->addSql('ALTER TABLE matchs ADD CONSTRAINT FK_6B1E60419470914 FOREIGN KEY (id_arbitre4) REFERENCES arbitre (id)');
        $this->addSql('ALTER TABLE matchs ADD CONSTRAINT FK_6B1E6041772C135C FOREIGN KEY (equipe2) REFERENCES equipe (id)');
        $this->addSql('ALTER TABLE matchs ADD CONSTRAINT FK_6B1E6041792DFD9B FOREIGN KEY (id_arbitre1) REFERENCES arbitre (id)');
        $this->addSql('ALTER TABLE matchs ADD CONSTRAINT FK_6B1E604197239CB7 FOREIGN KEY (id_arbitre3) REFERENCES arbitre (id)');
        $this->addSql('ALTER TABLE matchs ADD CONSTRAINT FK_6B1E6041EE2542E6 FOREIGN KEY (equipe1) REFERENCES equipe (id)');
        $this->addSql('ALTER TABLE matchs ADD CONSTRAINT FK_6B1E6041E024AC21 FOREIGN KEY (id_arbitre2) REFERENCES arbitre (id)');
        $this->addSql('ALTER TABLE order_items ADD CONSTRAINT FK_62809DB08D9F6D38 FOREIGN KEY (order_id) REFERENCES orders (id)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27FAABF2 FOREIGN KEY (id_cat) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE transfert ADD CONSTRAINT FK_1E4EACBB994AF3FA FOREIGN KEY (id_ancieneq) REFERENCES equipe (id)');
        $this->addSql('ALTER TABLE transfert ADD CONSTRAINT FK_1E4EACBBDB461C28 FOREIGN KEY (id_joueur) REFERENCES joueur (id)');
        $this->addSql('ALTER TABLE transfert ADD CONSTRAINT FK_1E4EACBB27874D50 FOREIGN KEY (id_nouveaueq) REFERENCES equipe (id)');
        $this->addSql('ALTER TABLE wishlist ADD CONSTRAINT FK_9CE12A31A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE wishlist_produit ADD CONSTRAINT FK_B6A93A5DFB8E54CD FOREIGN KEY (wishlist_id) REFERENCES wishlist (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE wishlist_produit ADD CONSTRAINT FK_B6A93A5DF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE matchs DROP FOREIGN KEY FK_6B1E60419470914');
        $this->addSql('ALTER TABLE matchs DROP FOREIGN KEY FK_6B1E6041792DFD9B');
        $this->addSql('ALTER TABLE matchs DROP FOREIGN KEY FK_6B1E604197239CB7');
        $this->addSql('ALTER TABLE matchs DROP FOREIGN KEY FK_6B1E6041E024AC21');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27FAABF2');
        $this->addSql('ALTER TABLE classment DROP FOREIGN KEY FK_31E06B0327E0FF8');
        $this->addSql('ALTER TABLE joueur DROP FOREIGN KEY FK_FD71A9C527E0FF8');
        $this->addSql('ALTER TABLE matchs DROP FOREIGN KEY FK_6B1E6041772C135C');
        $this->addSql('ALTER TABLE matchs DROP FOREIGN KEY FK_6B1E6041EE2542E6');
        $this->addSql('ALTER TABLE transfert DROP FOREIGN KEY FK_1E4EACBB994AF3FA');
        $this->addSql('ALTER TABLE transfert DROP FOREIGN KEY FK_1E4EACBB27874D50');
        $this->addSql('ALTER TABLE matchjoueur DROP FOREIGN KEY FK_C9233AF8DB461C28');
        $this->addSql('ALTER TABLE transfert DROP FOREIGN KEY FK_1E4EACBBDB461C28');
        $this->addSql('ALTER TABLE billet DROP FOREIGN KEY FK_1F034AF694DE8435');
        $this->addSql('ALTER TABLE matchjoueur DROP FOREIGN KEY FK_C9233AF894DE8435');
        $this->addSql('ALTER TABLE order_items DROP FOREIGN KEY FK_62809DB08D9F6D38');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF0F7384557');
        $this->addSql('ALTER TABLE wishlist_produit DROP FOREIGN KEY FK_B6A93A5DF347EFB');
        $this->addSql('ALTER TABLE arbitre DROP FOREIGN KEY FK_20B2E66EDC499668');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF06B3CA4B');
        $this->addSql('ALTER TABLE billet DROP FOREIGN KEY FK_1F034AF66B3CA4B');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEEA76ED395');
        $this->addSql('ALTER TABLE wishlist DROP FOREIGN KEY FK_9CE12A31A76ED395');
        $this->addSql('ALTER TABLE wishlist_produit DROP FOREIGN KEY FK_B6A93A5DFB8E54CD');
        $this->addSql('DROP TABLE arbitre');
        $this->addSql('DROP TABLE avis');
        $this->addSql('DROP TABLE billet');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE classment');
        $this->addSql('DROP TABLE equipe');
        $this->addSql('DROP TABLE joueur');
        $this->addSql('DROP TABLE matchjoueur');
        $this->addSql('DROP TABLE matchs');
        $this->addSql('DROP TABLE order_items');
        $this->addSql('DROP TABLE orders');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE role_arbitre');
        $this->addSql('DROP TABLE taille');
        $this->addSql('DROP TABLE transfert');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE wishlist');
        $this->addSql('DROP TABLE wishlist_produit');
    }
}
