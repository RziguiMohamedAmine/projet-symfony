<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220320104709 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE arbitre CHANGE id_role id_role INT DEFAULT NULL');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY fk_avis');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY fk_user');
        $this->addSql('ALTER TABLE avis CHANGE id_user id_user INT DEFAULT NULL, CHANGE id_produit id_produit INT DEFAULT NULL');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF0F7384557 FOREIGN KEY (id_produit) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF06B3CA4B FOREIGN KEY (id_user) REFERENCES user (id)');
        $this->addSql('ALTER TABLE billet DROP FOREIGN KEY forien_key');
        $this->addSql('ALTER TABLE billet DROP FOREIGN KEY user_fk');
        $this->addSql('ALTER TABLE billet CHANGE id_match id_match INT DEFAULT NULL');
        $this->addSql('ALTER TABLE billet ADD CONSTRAINT FK_1F034AF694DE8435 FOREIGN KEY (id_match) REFERENCES matchs (id)');
        $this->addSql('ALTER TABLE billet ADD CONSTRAINT FK_1F034AF66B3CA4B FOREIGN KEY (id_user) REFERENCES user (id)');
        $this->addSql('ALTER TABLE classment DROP FOREIGN KEY equipe_classment');
        $this->addSql('ALTER TABLE classment CHANGE id_equipe id_equipe INT DEFAULT NULL, CHANGE nb_totale_but nb_totale_but INT NOT NULL, CHANGE nb_totale_but_recu nb_totale_but_recu INT NOT NULL, CHANGE nb_point nb_point INT NOT NULL, CHANGE nb_win nb_win INT NOT NULL, CHANGE nb_draw nb_draw INT NOT NULL, CHANGE nb_lose nb_lose INT NOT NULL');
        $this->addSql('ALTER TABLE classment ADD CONSTRAINT FK_31E06B0327E0FF8 FOREIGN KEY (id_equipe) REFERENCES equipe (id)');
        $this->addSql('ALTER TABLE joueur DROP FOREIGN KEY joueur_ibfk_1');
        $this->addSql('ALTER TABLE joueur ADD CONSTRAINT FK_FD71A9C527E0FF8 FOREIGN KEY (id_equipe) REFERENCES equipe (id)');
        $this->addSql('ALTER TABLE matchjoueur DROP FOREIGN KEY matchjoueur_ibfk_1');
        $this->addSql('ALTER TABLE matchjoueur DROP FOREIGN KEY matchjoueur_ibfk_2');
        $this->addSql('ALTER TABLE matchjoueur CHANGE id_joueur id_joueur INT DEFAULT NULL, CHANGE id_match id_match INT DEFAULT NULL');
        $this->addSql('ALTER TABLE matchjoueur ADD CONSTRAINT FK_C9233AF8DB461C28 FOREIGN KEY (id_joueur) REFERENCES joueur (id)');
        $this->addSql('ALTER TABLE matchjoueur ADD CONSTRAINT FK_C9233AF894DE8435 FOREIGN KEY (id_match) REFERENCES matchs (id)');
        $this->addSql('ALTER TABLE matchs DROP FOREIGN KEY arbitre_FK4');
        $this->addSql('ALTER TABLE matchs DROP FOREIGN KEY equipe_FK2');
        $this->addSql('ALTER TABLE matchs DROP FOREIGN KEY arbitre_FK1');
        $this->addSql('ALTER TABLE matchs DROP FOREIGN KEY arbitre_FK3');
        $this->addSql('ALTER TABLE matchs DROP FOREIGN KEY equipe_FK1');
        $this->addSql('ALTER TABLE matchs DROP FOREIGN KEY arbitre_FK2');
        $this->addSql('ALTER TABLE matchs CHANGE equipe1 equipe1 INT DEFAULT NULL, CHANGE equipe2 equipe2 INT DEFAULT NULL, CHANGE stade stade VARCHAR(100) NOT NULL, CHANGE round round INT NOT NULL');
        $this->addSql('ALTER TABLE matchs ADD CONSTRAINT FK_6B1E60419470914 FOREIGN KEY (id_arbitre4) REFERENCES arbitre (id)');
        $this->addSql('ALTER TABLE matchs ADD CONSTRAINT FK_6B1E6041772C135C FOREIGN KEY (equipe2) REFERENCES equipe (id)');
        $this->addSql('ALTER TABLE matchs ADD CONSTRAINT FK_6B1E6041792DFD9B FOREIGN KEY (id_arbitre1) REFERENCES arbitre (id)');
        $this->addSql('ALTER TABLE matchs ADD CONSTRAINT FK_6B1E604197239CB7 FOREIGN KEY (id_arbitre3) REFERENCES arbitre (id)');
        $this->addSql('ALTER TABLE matchs ADD CONSTRAINT FK_6B1E6041EE2542E6 FOREIGN KEY (equipe1) REFERENCES equipe (id)');
        $this->addSql('ALTER TABLE matchs ADD CONSTRAINT FK_6B1E6041E024AC21 FOREIGN KEY (id_arbitre2) REFERENCES arbitre (id)');
        $this->addSql('ALTER TABLE order_items DROP FOREIGN KEY order_items_ibfk_1');
        $this->addSql('ALTER TABLE order_items CHANGE order_id order_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE order_items ADD CONSTRAINT FK_62809DB08D9F6D38 FOREIGN KEY (order_id) REFERENCES orders (id)');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY order_user_FK');
        $this->addSql('ALTER TABLE orders CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY fk');
        $this->addSql('ALTER TABLE produit CHANGE id_cat id_cat INT DEFAULT NULL, CHANGE stock stock INT NOT NULL');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27FAABF2 FOREIGN KEY (id_cat) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE taille CHANGE stock stock INT NOT NULL');
        $this->addSql('ALTER TABLE transfert CHANGE id_ancieneq id_ancieneq INT DEFAULT NULL, CHANGE id_nouveaueq id_nouveaueq INT DEFAULT NULL, CHANGE id_joueur id_joueur INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE ban ban TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE arbitre CHANGE id_role id_role INT NOT NULL, CHANGE nom nom VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE prenom prenom VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE image image VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE email email VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF0F7384557');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF06B3CA4B');
        $this->addSql('ALTER TABLE avis CHANGE id_produit id_produit INT NOT NULL, CHANGE id_user id_user INT NOT NULL');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT fk_avis FOREIGN KEY (id_produit) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT fk_user FOREIGN KEY (id_user) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE billet DROP FOREIGN KEY FK_1F034AF694DE8435');
        $this->addSql('ALTER TABLE billet DROP FOREIGN KEY FK_1F034AF66B3CA4B');
        $this->addSql('ALTER TABLE billet CHANGE id_match id_match INT NOT NULL, CHANGE bloc bloc VARCHAR(500) NOT NULL COLLATE `utf8mb4_general_ci`');
        $this->addSql('ALTER TABLE billet ADD CONSTRAINT forien_key FOREIGN KEY (id_match) REFERENCES matchs (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE billet ADD CONSTRAINT user_fk FOREIGN KEY (id_user) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categorie CHANGE nom nom VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`');
        $this->addSql('ALTER TABLE classment DROP FOREIGN KEY FK_31E06B0327E0FF8');
        $this->addSql('ALTER TABLE classment CHANGE id_equipe id_equipe INT NOT NULL, CHANGE nb_totale_but nb_totale_but INT DEFAULT 0 NOT NULL, CHANGE nb_totale_but_recu nb_totale_but_recu INT DEFAULT 0 NOT NULL, CHANGE nb_point nb_point INT DEFAULT 0 NOT NULL, CHANGE saison saison VARCHAR(8) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE nb_win nb_win INT DEFAULT 0 NOT NULL, CHANGE nb_draw nb_draw INT DEFAULT 0 NOT NULL, CHANGE nb_lose nb_lose INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE classment ADD CONSTRAINT equipe_classment FOREIGN KEY (id_equipe) REFERENCES equipe (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE equipe CHANGE nomeq nomeq VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE logo logo VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE nom_entreneur nom_entreneur VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE niveau niveau VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE stade stade VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`');
        $this->addSql('ALTER TABLE joueur DROP FOREIGN KEY FK_FD71A9C527E0FF8');
        $this->addSql('ALTER TABLE joueur CHANGE nom nom VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE prenom prenom VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE poste poste VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE nationalite nationalite VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE image image VARCHAR(200) NOT NULL COLLATE `utf8mb4_general_ci`');
        $this->addSql('ALTER TABLE joueur ADD CONSTRAINT joueur_ibfk_1 FOREIGN KEY (id_equipe) REFERENCES equipe (id) ON UPDATE NO ACTION ON DELETE SET NULL');
        $this->addSql('ALTER TABLE matchjoueur DROP FOREIGN KEY FK_C9233AF8DB461C28');
        $this->addSql('ALTER TABLE matchjoueur DROP FOREIGN KEY FK_C9233AF894DE8435');
        $this->addSql('ALTER TABLE matchjoueur CHANGE id_joueur id_joueur INT NOT NULL, CHANGE id_match id_match INT NOT NULL');
        $this->addSql('ALTER TABLE matchjoueur ADD CONSTRAINT matchjoueur_ibfk_1 FOREIGN KEY (id_joueur) REFERENCES joueur (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE matchjoueur ADD CONSTRAINT matchjoueur_ibfk_2 FOREIGN KEY (id_match) REFERENCES matchs (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE matchs DROP FOREIGN KEY FK_6B1E60419470914');
        $this->addSql('ALTER TABLE matchs DROP FOREIGN KEY FK_6B1E6041772C135C');
        $this->addSql('ALTER TABLE matchs DROP FOREIGN KEY FK_6B1E6041792DFD9B');
        $this->addSql('ALTER TABLE matchs DROP FOREIGN KEY FK_6B1E604197239CB7');
        $this->addSql('ALTER TABLE matchs DROP FOREIGN KEY FK_6B1E6041EE2542E6');
        $this->addSql('ALTER TABLE matchs DROP FOREIGN KEY FK_6B1E6041E024AC21');
        $this->addSql('ALTER TABLE matchs CHANGE equipe2 equipe2 INT NOT NULL, CHANGE equipe1 equipe1 INT NOT NULL, CHANGE stade stade VARCHAR(100) DEFAULT \'\' NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE saison saison VARCHAR(8) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE round round INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE matchs ADD CONSTRAINT arbitre_FK4 FOREIGN KEY (id_arbitre4) REFERENCES arbitre (id) ON UPDATE NO ACTION ON DELETE SET NULL');
        $this->addSql('ALTER TABLE matchs ADD CONSTRAINT equipe_FK2 FOREIGN KEY (equipe2) REFERENCES equipe (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE matchs ADD CONSTRAINT arbitre_FK1 FOREIGN KEY (id_arbitre1) REFERENCES arbitre (id) ON UPDATE NO ACTION ON DELETE SET NULL');
        $this->addSql('ALTER TABLE matchs ADD CONSTRAINT arbitre_FK3 FOREIGN KEY (id_arbitre3) REFERENCES arbitre (id) ON UPDATE NO ACTION ON DELETE SET NULL');
        $this->addSql('ALTER TABLE matchs ADD CONSTRAINT equipe_FK1 FOREIGN KEY (equipe1) REFERENCES equipe (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE matchs ADD CONSTRAINT arbitre_FK2 FOREIGN KEY (id_arbitre2) REFERENCES arbitre (id) ON UPDATE NO ACTION ON DELETE SET NULL');
        $this->addSql('ALTER TABLE order_items DROP FOREIGN KEY FK_62809DB08D9F6D38');
        $this->addSql('ALTER TABLE order_items CHANGE order_id order_id INT NOT NULL');
        $this->addSql('ALTER TABLE order_items ADD CONSTRAINT order_items_ibfk_1 FOREIGN KEY (order_id) REFERENCES orders (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEEA76ED395');
        $this->addSql('ALTER TABLE orders CHANGE user_id user_id INT NOT NULL, CHANGE state state VARCHAR(20) DEFAULT \'pending\' NOT NULL COLLATE `utf8mb4_general_ci`');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT order_user_FK FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27FAABF2');
        $this->addSql('ALTER TABLE produit CHANGE id_cat id_cat INT NOT NULL, CHANGE nom nom VARCHAR(255) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE image image VARCHAR(500) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE description description VARCHAR(500) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE stock stock INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT fk FOREIGN KEY (id_cat) REFERENCES categorie (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE role_arbitre CHANGE role role VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE description description VARCHAR(500) NOT NULL COLLATE `utf8mb4_general_ci`');
        $this->addSql('ALTER TABLE taille CHANGE nom nom VARCHAR(500) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE stock stock INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE transfert CHANGE id_ancieneq id_ancieneq INT NOT NULL, CHANGE id_joueur id_joueur INT NOT NULL, CHANGE id_nouveaueq id_nouveaueq INT NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE nom nom VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE prenom prenom VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE email email VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE pass pass VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE ban ban TINYINT(1) DEFAULT 0 NOT NULL, CHANGE forgetpassCode forgetpassCode VARCHAR(50) DEFAULT NULL COLLATE `utf8mb4_general_ci`, CHANGE role role VARCHAR(50) DEFAULT \'user\' NOT NULL COLLATE `utf8mb4_general_ci`');
    }
}
