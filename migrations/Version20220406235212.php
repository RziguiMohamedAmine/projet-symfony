<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220406235212 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF06B3CA4B');
        $this->addSql('DROP INDEX fk_8f91abf06b3ca4b ON avis');
        $this->addSql('CREATE INDEX fk_user ON avis (id_user)');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF06B3CA4B FOREIGN KEY (id_user) REFERENCES user (id)');
        $this->addSql('ALTER TABLE billet DROP FOREIGN KEY FK_1F034AF66B3CA4B');
        $this->addSql('DROP INDEX fk_1f034af66b3ca4b ON billet');
        $this->addSql('CREATE INDEX user_fk ON billet (id_user)');
        $this->addSql('ALTER TABLE billet ADD CONSTRAINT FK_1F034AF66B3CA4B FOREIGN KEY (id_user) REFERENCES user (id)');
        $this->addSql('ALTER TABLE matchs CHANGE nb_but1 nb_but1 INT NOT NULL, CHANGE nb_but2 nb_but2 INT NOT NULL');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEEA76ED395');
        $this->addSql('DROP INDEX fk_e52ffdeea76ed395 ON orders');
        $this->addSql('CREATE INDEX order_user_FK ON orders (user_id)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE transfert CHANGE id_ancieneq id_ancieneq INT DEFAULT NULL, CHANGE id_nouveaueq id_nouveaueq INT DEFAULT NULL, CHANGE id_joueur id_joueur INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE ban ban TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE arbitre CHANGE nom nom VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE prenom prenom VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE image image VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE email email VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF06B3CA4B');
        $this->addSql('DROP INDEX fk_user ON avis');
        $this->addSql('CREATE INDEX FK_8F91ABF06B3CA4B ON avis (id_user)');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF06B3CA4B FOREIGN KEY (id_user) REFERENCES user (id)');
        $this->addSql('ALTER TABLE billet DROP FOREIGN KEY FK_1F034AF66B3CA4B');
        $this->addSql('ALTER TABLE billet CHANGE bloc bloc VARCHAR(500) NOT NULL COLLATE `utf8mb4_general_ci`');
        $this->addSql('DROP INDEX user_fk ON billet');
        $this->addSql('CREATE INDEX FK_1F034AF66B3CA4B ON billet (id_user)');
        $this->addSql('ALTER TABLE billet ADD CONSTRAINT FK_1F034AF66B3CA4B FOREIGN KEY (id_user) REFERENCES user (id)');
        $this->addSql('ALTER TABLE categorie CHANGE nom nom VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`');
        $this->addSql('ALTER TABLE classment CHANGE saison saison VARCHAR(8) NOT NULL COLLATE `utf8mb4_general_ci`');
        $this->addSql('ALTER TABLE equipe CHANGE nomeq nomeq VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE logo logo VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE nom_entreneur nom_entreneur VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE niveau niveau VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE stade stade VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`');
        $this->addSql('ALTER TABLE joueur CHANGE nom nom VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE prenom prenom VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE poste poste VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE nationalite nationalite VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE image image VARCHAR(200) NOT NULL COLLATE `utf8mb4_general_ci`');
        $this->addSql('ALTER TABLE matchs CHANGE nb_but1 nb_but1 INT DEFAULT -1 NOT NULL, CHANGE nb_but2 nb_but2 INT DEFAULT -1 NOT NULL, CHANGE stade stade VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE saison saison VARCHAR(8) NOT NULL COLLATE `utf8mb4_general_ci`');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEEA76ED395');
        $this->addSql('ALTER TABLE orders CHANGE state state VARCHAR(20) DEFAULT \'pending\' NOT NULL COLLATE `utf8mb4_general_ci`');
        $this->addSql('DROP INDEX order_user_fk ON orders');
        $this->addSql('CREATE INDEX FK_E52FFDEEA76ED395 ON orders (user_id)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE produit CHANGE nom nom VARCHAR(255) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE image image VARCHAR(500) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE description description VARCHAR(500) NOT NULL COLLATE `utf8mb4_general_ci`');
        $this->addSql('ALTER TABLE role_arbitre CHANGE role role VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE description description VARCHAR(500) NOT NULL COLLATE `utf8mb4_general_ci`');
        $this->addSql('ALTER TABLE transfert CHANGE id_ancieneq id_ancieneq INT NOT NULL, CHANGE id_joueur id_joueur INT NOT NULL, CHANGE id_nouveaueq id_nouveaueq INT NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE nom nom VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE prenom prenom VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE email email VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE pass pass VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE ban ban TINYINT(1) DEFAULT 0 NOT NULL, CHANGE forgetpassCode forgetpassCode VARCHAR(50) DEFAULT NULL COLLATE `utf8mb4_general_ci`, CHANGE role role VARCHAR(50) DEFAULT \'user\' NOT NULL COLLATE `utf8mb4_general_ci`');
    }
}
