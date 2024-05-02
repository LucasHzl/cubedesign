<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240502152046 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE products_orders DROP FOREIGN KEY FK_631C76C46C8A81A9');
        $this->addSql('ALTER TABLE products_orders DROP FOREIGN KEY FK_631C76C4CFFE9AD6');
        $this->addSql('DROP INDEX IDX_631C76C4CFFE9AD6 ON products_orders');
        $this->addSql('DROP INDEX IDX_631C76C46C8A81A9 ON products_orders');
        $this->addSql('ALTER TABLE products_orders ADD id INT AUTO_INCREMENT NOT NULL, ADD order_id_id INT NOT NULL, ADD product_id_id INT NOT NULL, ADD quantity INT NOT NULL, DROP products_id, DROP orders_id, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE products_orders ADD CONSTRAINT FK_631C76C4FCDAEAAA FOREIGN KEY (order_id_id) REFERENCES orders (id)');
        $this->addSql('ALTER TABLE products_orders ADD CONSTRAINT FK_631C76C4DE18E50B FOREIGN KEY (product_id_id) REFERENCES products (id)');
        $this->addSql('CREATE INDEX IDX_631C76C4FCDAEAAA ON products_orders (order_id_id)');
        $this->addSql('CREATE INDEX IDX_631C76C4DE18E50B ON products_orders (product_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE products_orders MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE products_orders DROP FOREIGN KEY FK_631C76C4FCDAEAAA');
        $this->addSql('ALTER TABLE products_orders DROP FOREIGN KEY FK_631C76C4DE18E50B');
        $this->addSql('DROP INDEX IDX_631C76C4FCDAEAAA ON products_orders');
        $this->addSql('DROP INDEX IDX_631C76C4DE18E50B ON products_orders');
        $this->addSql('DROP INDEX `PRIMARY` ON products_orders');
        $this->addSql('ALTER TABLE products_orders ADD products_id INT NOT NULL, ADD orders_id INT NOT NULL, DROP id, DROP order_id_id, DROP product_id_id, DROP quantity');
        $this->addSql('ALTER TABLE products_orders ADD CONSTRAINT FK_631C76C46C8A81A9 FOREIGN KEY (products_id) REFERENCES products (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE products_orders ADD CONSTRAINT FK_631C76C4CFFE9AD6 FOREIGN KEY (orders_id) REFERENCES orders (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_631C76C4CFFE9AD6 ON products_orders (orders_id)');
        $this->addSql('CREATE INDEX IDX_631C76C46C8A81A9 ON products_orders (products_id)');
        $this->addSql('ALTER TABLE products_orders ADD PRIMARY KEY (products_id, orders_id)');
    }
}
