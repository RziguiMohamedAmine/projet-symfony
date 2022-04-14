<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220414004724 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE arbitre CHANGE nom nom VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE prenom prenom VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE image image VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE email email VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`');
        $this->addSql('ALTER TABLE billet CHANGE bloc bloc VARCHAR(500) NOT NULL COLLATE `utf8mb4_general_ci`');
        $this->addSql('ALTER TABLE categorie CHANGE nom nom VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`');
        $this->addSql('ALTER TABLE classment CHANGE saison saison VARCHAR(8) NOT NULL COLLATE `utf8mb4_general_ci`');
        $this->addSql('ALTER TABLE equipe CHANGE nomeq nomeq VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE logo logo VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE nom_entreneur nom_entreneur VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE niveau niveau VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE stade stade VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`');
        $this->addSql('ALTER TABLE joueur CHANGE nom nom VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE prenom prenom VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE poste poste VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE nationalite nationalite VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE image image VARCHAR(200) NOT NULL COLLATE `utf8mb4_general_ci`');
        $this->addSql('ALTER TABLE matchs CHANGE stade stade VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE saison saison VARCHAR(8) NOT NULL COLLATE `utf8mb4_general_ci`');
        $this->addSql('ALTER TABLE orders CHANGE state state VARCHAR(20) DEFAULT \'pending\' NOT NULL COLLATE `utf8mb4_general_ci`');
        $this->addSql('ALTER TABLE produit CHANGE nom nom VARCHAR(255) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE image image VARCHAR(500) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE description description VARCHAR(500) NOT NULL COLLATE `utf8mb4_general_ci`');
        $this->addSql('ALTER TABLE role_arbitre CHANGE role role VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE description description VARCHAR(500) NOT NULL COLLATE `utf8mb4_general_ci`');
        $this->addSql('ALTER TABLE user CHANGE nom nom VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE prenom prenom VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE email email VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE pass pass VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE forgetpassCode forgetpassCode VARCHAR(50) DEFAULT NULL COLLATE `utf8mb4_general_ci`, CHANGE role role VARCHAR(50) DEFAULT \'user\' NOT NULL COLLATE `utf8mb4_general_ci`');
    }
}
