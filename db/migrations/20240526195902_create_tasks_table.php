<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTasksTable extends AbstractMigration
{
    /**
     * @return void
     */
    public function up(): void
    {
        $this->table('tasks')
            ->addColumn('title', 'string', ['limit' => 255])
            ->addColumn('priority', 'smallinteger', ['signed' => false])
            ->addColumn('user_id', 'integer', ['signed' => false])
            ->addForeignKey('user_id', 'users', 'id', ['delete' => 'cascade'])
            ->save();
    }

    /**
     * @return void
     */
    public function down(): void
    {
        $this->table('tasks')->drop()->save();
    }
}
