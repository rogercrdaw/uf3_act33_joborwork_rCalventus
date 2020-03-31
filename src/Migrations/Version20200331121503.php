<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200331121503 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE candidat CHANGE estudis estudis VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE candidat ADD CONSTRAINT FK_6AB5B4715F263030 FOREIGN KEY (usuari_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE empresa CHANGE logo logo VARCHAR(255) DEFAULT NULL, CHANGE correu correu VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE empresa ADD CONSTRAINT FK_B8D75A50DB38439E FOREIGN KEY (usuario_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE oferta CHANGE data_publicacio data_publicacio DATETIME NOT NULL');
        $this->addSql('ALTER TABLE oferta ADD CONSTRAINT FK_7479C8F2521E1991 FOREIGN KEY (empresa_id) REFERENCES empresa (id)');
        $this->addSql('ALTER TABLE oferta_candidat ADD CONSTRAINT FK_BC759CA0FAFBF624 FOREIGN KEY (oferta_id) REFERENCES oferta (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE oferta_candidat ADD CONSTRAINT FK_BC759CA08D0EB82 FOREIGN KEY (candidat_id) REFERENCES candidat (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD pass VARCHAR(255) NOT NULL, CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE roles roles JSON NOT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE candidat DROP FOREIGN KEY FK_6AB5B4715F263030');
        $this->addSql('ALTER TABLE candidat CHANGE estudis estudis VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE empresa DROP FOREIGN KEY FK_B8D75A50DB38439E');
        $this->addSql('ALTER TABLE empresa CHANGE logo logo VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE correu correu VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE oferta DROP FOREIGN KEY FK_7479C8F2521E1991');
        $this->addSql('ALTER TABLE oferta CHANGE data_publicacio data_publicacio DATETIME DEFAULT \'current_timestamp()\' NOT NULL');
        $this->addSql('ALTER TABLE oferta_candidat DROP FOREIGN KEY FK_BC759CA0FAFBF624');
        $this->addSql('ALTER TABLE oferta_candidat DROP FOREIGN KEY FK_BC759CA08D0EB82');
        $this->addSql('ALTER TABLE user MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74 ON user');
        $this->addSql('ALTER TABLE user DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE user DROP pass, CHANGE id id INT NOT NULL, CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
