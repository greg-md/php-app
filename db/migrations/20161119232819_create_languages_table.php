<?php

use Phinx\Migration\AbstractMigration;

class CreateLanguagesTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $this->table('Languages', ['id' => false, 'primary_key' => 'SystemName'])
            ->addColumn('SystemName', 'string', ['limit' => 10])
            ->addColumn('Rank', 'integer', ['limit' => 10, 'signed' => false, 'default' => 0])
            ->addColumn('Locale', 'string', ['limit' => 50, 'null' => true])
            ->addColumn('Name', 'string', ['limit' => 20])
            ->addColumn('Short', 'string', ['limit' => 5])
            ->addColumn('Base', 'boolean', ['signed' => false, 'default' => 0])
            ->addColumn('Active', 'boolean', ['signed' => false, 'default' => 1])
            ->create();
    }
}
