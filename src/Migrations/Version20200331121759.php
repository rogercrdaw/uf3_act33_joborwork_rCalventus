<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200331121759 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE candidat (id INT AUTO_INCREMENT NOT NULL, usuari_id INT NOT NULL, nom VARCHAR(255) NOT NULL, cognoms VARCHAR(255) NOT NULL, telefon INT NOT NULL, estudis VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_6AB5B4715F263030 (usuari_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE oferta (id INT AUTO_INCREMENT NOT NULL, empresa_id INT NOT NULL, titol VARCHAR(255) NOT NULL, descripcio LONGTEXT DEFAULT NULL, resum LONGTEXT NOT NULL, data_publicacio DATETIME NOT NULL, requisits LONGTEXT DEFAULT NULL, INDEX IDX_7479C8F2521E1991 (empresa_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE oferta_candidat (oferta_id INT NOT NULL, candidat_id INT NOT NULL, INDEX IDX_BC759CA0FAFBF624 (oferta_id), INDEX IDX_BC759CA08D0EB82 (candidat_id), PRIMARY KEY(oferta_id, candidat_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, pass VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE candidat ADD CONSTRAINT FK_6AB5B4715F263030 FOREIGN KEY (usuari_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE oferta ADD CONSTRAINT FK_7479C8F2521E1991 FOREIGN KEY (empresa_id) REFERENCES empresa (id)');
        $this->addSql('ALTER TABLE oferta_candidat ADD CONSTRAINT FK_BC759CA0FAFBF624 FOREIGN KEY (oferta_id) REFERENCES oferta (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE oferta_candidat ADD CONSTRAINT FK_BC759CA08D0EB82 FOREIGN KEY (candidat_id) REFERENCES candidat (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE empresa CHANGE logo logo VARCHAR(255) DEFAULT NULL, CHANGE correu correu VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE empresa ADD CONSTRAINT FK_B8D75A50DB38439E FOREIGN KEY (usuario_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE oferta_candidat DROP FOREIGN KEY FK_BC759CA08D0EB82');
        $this->addSql('ALTER TABLE oferta_candidat DROP FOREIGN KEY FK_BC759CA0FAFBF624');
        $this->addSql('ALTER TABLE candidat DROP FOREIGN KEY FK_6AB5B4715F263030');
        $this->addSql('ALTER TABLE empresa DROP FOREIGN KEY FK_B8D75A50DB38439E');
        $this->addSql('DROP TABLE candidat');
        $this->addSql('DROP TABLE oferta');
        $this->addSql('DROP TABLE oferta_candidat');
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE empresa CHANGE logo logo VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE correu correu VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
    }
}
