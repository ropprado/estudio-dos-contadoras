<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211114213029 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categoria (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entrada (id INT AUTO_INCREMENT NOT NULL, categoria_id INT NOT NULL, titulo VARCHAR(255) NOT NULL, fecha DATETIME NOT NULL, contenido LONGTEXT NOT NULL, INDEX IDX_C949A2743397707A (categoria_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entrada_etiqueta (entrada_id INT NOT NULL, etiqueta_id INT NOT NULL, INDEX IDX_E1CFEEA4A688222A (entrada_id), INDEX IDX_E1CFEEA4D53DA3AB (etiqueta_id), PRIMARY KEY(entrada_id, etiqueta_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etiqueta (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE entrada ADD CONSTRAINT FK_C949A2743397707A FOREIGN KEY (categoria_id) REFERENCES categoria (id)');
        $this->addSql('ALTER TABLE entrada_etiqueta ADD CONSTRAINT FK_E1CFEEA4A688222A FOREIGN KEY (entrada_id) REFERENCES entrada (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE entrada_etiqueta ADD CONSTRAINT FK_E1CFEEA4D53DA3AB FOREIGN KEY (etiqueta_id) REFERENCES etiqueta (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE entrada DROP FOREIGN KEY FK_C949A2743397707A');
        $this->addSql('ALTER TABLE entrada_etiqueta DROP FOREIGN KEY FK_E1CFEEA4A688222A');
        $this->addSql('ALTER TABLE entrada_etiqueta DROP FOREIGN KEY FK_E1CFEEA4D53DA3AB');
        $this->addSql('DROP TABLE categoria');
        $this->addSql('DROP TABLE entrada');
        $this->addSql('DROP TABLE entrada_etiqueta');
        $this->addSql('DROP TABLE etiqueta');
    }
}
