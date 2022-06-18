<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220507104953 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE profanities (id INT AUTO_INCREMENT NOT NULL, word VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_B8715B4C3F17511 (word), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wishlist (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_9CE12A31A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wishlist_produit (wishlist_id INT NOT NULL, produit_id INT NOT NULL, INDEX IDX_B6A93A5DFB8E54CD (wishlist_id), INDEX IDX_B6A93A5DF347EFB (produit_id), PRIMARY KEY(wishlist_id, produit_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE wishlist ADD CONSTRAINT FK_9CE12A31A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE wishlist_produit ADD CONSTRAINT FK_B6A93A5DFB8E54CD FOREIGN KEY (wishlist_id) REFERENCES wishlist (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE wishlist_produit ADD CONSTRAINT FK_B6A93A5DF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE billet DROP FOREIGN KEY FK_1F034AF694DE8435');
        $this->addSql('ALTER TABLE billet DROP FOREIGN KEY FK_1F034AF66B3CA4B');
        $this->addSql('ALTER TABLE billet ADD CONSTRAINT FK_1F034AF694DE8435 FOREIGN KEY (id_match) REFERENCES matchs (id)');
        $this->addSql('ALTER TABLE billet ADD CONSTRAINT FK_1F034AF66B3CA4B FOREIGN KEY (id_user) REFERENCES user (id)');
        $this->addSql('ALTER TABLE classment DROP FOREIGN KEY FK_31E06B0327E0FF8');
        $this->addSql('ALTER TABLE classment ADD CONSTRAINT FK_31E06B0327E0FF8 FOREIGN KEY (id_equipe) REFERENCES equipe (id)');
        $this->addSql('ALTER TABLE matchjoueur DROP FOREIGN KEY FK_C9233AF8DB461C28');
        $this->addSql('ALTER TABLE matchjoueur DROP FOREIGN KEY FK_C9233AF894DE8435');
        $this->addSql('ALTER TABLE matchjoueur ADD CONSTRAINT FK_C9233AF8DB461C28 FOREIGN KEY (id_joueur) REFERENCES joueur (id)');
        $this->addSql('ALTER TABLE matchjoueur ADD CONSTRAINT FK_C9233AF894DE8435 FOREIGN KEY (id_match) REFERENCES matchs (id)');
        $this->addSql('ALTER TABLE matchs DROP FOREIGN KEY FK_6B1E6041792DFD9B');
        $this->addSql('ALTER TABLE matchs DROP FOREIGN KEY FK_6B1E604197239CB7');
        $this->addSql('ALTER TABLE matchs DROP FOREIGN KEY FK_6B1E6041EE2542E6');
        $this->addSql('ALTER TABLE matchs DROP FOREIGN KEY FK_6B1E6041772C135C');
        $this->addSql('ALTER TABLE matchs DROP FOREIGN KEY FK_6B1E60419470914');
        $this->addSql('ALTER TABLE matchs DROP FOREIGN KEY FK_6B1E6041E024AC21');
        $this->addSql('ALTER TABLE matchs CHANGE date date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE matchs ADD CONSTRAINT FK_6B1E6041792DFD9B FOREIGN KEY (id_arbitre1) REFERENCES arbitre (id)');
        $this->addSql('ALTER TABLE matchs ADD CONSTRAINT FK_6B1E604197239CB7 FOREIGN KEY (id_arbitre3) REFERENCES arbitre (id)');
        $this->addSql('ALTER TABLE matchs ADD CONSTRAINT FK_6B1E6041EE2542E6 FOREIGN KEY (equipe1) REFERENCES equipe (id)');
        $this->addSql('ALTER TABLE matchs ADD CONSTRAINT FK_6B1E6041772C135C FOREIGN KEY (equipe2) REFERENCES equipe (id)');
        $this->addSql('ALTER TABLE matchs ADD CONSTRAINT FK_6B1E60419470914 FOREIGN KEY (id_arbitre4) REFERENCES arbitre (id)');
        $this->addSql('ALTER TABLE matchs ADD CONSTRAINT FK_6B1E6041E024AC21 FOREIGN KEY (id_arbitre2) REFERENCES arbitre (id)');
        $this->addSql('ALTER TABLE produit CHANGE description description VARCHAR(1000) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE wishlist_produit DROP FOREIGN KEY FK_B6A93A5DFB8E54CD');
        $this->addSql('DROP TABLE profanities');
        $this->addSql('DROP TABLE wishlist');
        $this->addSql('DROP TABLE wishlist_produit');
        $this->addSql('ALTER TABLE arbitre CHANGE nom nom VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE prenom prenom VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE image image VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE email email VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`');
        $this->addSql('ALTER TABLE billet DROP FOREIGN KEY FK_1F034AF694DE8435');
        $this->addSql('ALTER TABLE billet DROP FOREIGN KEY FK_1F034AF66B3CA4B');
        $this->addSql('ALTER TABLE billet CHANGE bloc bloc VARCHAR(500) NOT NULL COLLATE `utf8mb4_general_ci`');
        $this->addSql('ALTER TABLE billet ADD CONSTRAINT FK_1F034AF694DE8435 FOREIGN KEY (id_match) REFERENCES matchs (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE billet ADD CONSTRAINT FK_1F034AF66B3CA4B FOREIGN KEY (id_user) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE SET NULL');
        $this->addSql('ALTER TABLE categorie CHANGE nom nom VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`');
        $this->addSql('ALTER TABLE classment DROP FOREIGN KEY FK_31E06B0327E0FF8');
        $this->addSql('ALTER TABLE classment CHANGE saison saison VARCHAR(8) NOT NULL COLLATE `utf8mb4_general_ci`');
        $this->addSql('ALTER TABLE classment ADD CONSTRAINT FK_31E06B0327E0FF8 FOREIGN KEY (id_equipe) REFERENCES equipe (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE equipe CHANGE nomeq nomeq VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE logo logo VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE nom_entreneur nom_entreneur VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE niveau niveau VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE stade stade VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`');
        $this->addSql('ALTER TABLE joueur CHANGE nom nom VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE prenom prenom VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE poste poste VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE nationalite nationalite VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE image image VARCHAR(200) NOT NULL COLLATE `utf8mb4_general_ci`');
        $this->addSql('ALTER TABLE matchjoueur DROP FOREIGN KEY FK_C9233AF8DB461C28');
        $this->addSql('ALTER TABLE matchjoueur DROP FOREIGN KEY FK_C9233AF894DE8435');
        $this->addSql('ALTER TABLE matchjoueur ADD CONSTRAINT FK_C9233AF8DB461C28 FOREIGN KEY (id_joueur) REFERENCES joueur (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE matchjoueur ADD CONSTRAINT FK_C9233AF894DE8435 FOREIGN KEY (id_match) REFERENCES matchs (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE matchs DROP FOREIGN KEY FK_6B1E6041EE2542E6');
        $this->addSql('ALTER TABLE matchs DROP FOREIGN KEY FK_6B1E6041772C135C');
        $this->addSql('ALTER TABLE matchs DROP FOREIGN KEY FK_6B1E6041792DFD9B');
        $this->addSql('ALTER TABLE matchs DROP FOREIGN KEY FK_6B1E6041E024AC21');
        $this->addSql('ALTER TABLE matchs DROP FOREIGN KEY FK_6B1E604197239CB7');
        $this->addSql('ALTER TABLE matchs DROP FOREIGN KEY FK_6B1E60419470914');
        $this->addSql('ALTER TABLE matchs CHANGE stade stade VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE date date DATETIME DEFAULT NULL, CHANGE saison saison VARCHAR(8) NOT NULL COLLATE `utf8mb4_general_ci`');
        $this->addSql('ALTER TABLE matchs ADD CONSTRAINT FK_6B1E6041EE2542E6 FOREIGN KEY (equipe1) REFERENCES equipe (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE matchs ADD CONSTRAINT FK_6B1E6041772C135C FOREIGN KEY (equipe2) REFERENCES equipe (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE matchs ADD CONSTRAINT FK_6B1E6041792DFD9B FOREIGN KEY (id_arbitre1) REFERENCES arbitre (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE matchs ADD CONSTRAINT FK_6B1E6041E024AC21 FOREIGN KEY (id_arbitre2) REFERENCES arbitre (id) ON UPDATE NO ACTION ON DELETE SET NULL');
        $this->addSql('ALTER TABLE matchs ADD CONSTRAINT FK_6B1E604197239CB7 FOREIGN KEY (id_arbitre3) REFERENCES arbitre (id) ON UPDATE NO ACTION ON DELETE SET NULL');
        $this->addSql('ALTER TABLE matchs ADD CONSTRAINT FK_6B1E60419470914 FOREIGN KEY (id_arbitre4) REFERENCES arbitre (id) ON UPDATE NO ACTION ON DELETE SET NULL');
        $this->addSql('ALTER TABLE orders CHANGE state state VARCHAR(20) DEFAULT \'pending\' NOT NULL COLLATE `utf8mb4_general_ci`');
        $this->addSql('ALTER TABLE produit CHANGE nom nom VARCHAR(255) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE image image VARCHAR(500) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE description description VARCHAR(500) NOT NULL COLLATE `utf8mb4_general_ci`');
        $this->addSql('ALTER TABLE role_arbitre CHANGE role role VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE description description VARCHAR(500) NOT NULL COLLATE `utf8mb4_general_ci`');
        $this->addSql('ALTER TABLE taille CHANGE nom nom VARCHAR(500) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`');
        $this->addSql('ALTER TABLE user CHANGE email email VARCHAR(180) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_general_ci` COMMENT \'(DC2Type:json)\', CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE nom nom VARCHAR(255) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE prenom prenom VARCHAR(255) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE forgetpass_code forgetpass_code VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_general_ci`');
    }
}
