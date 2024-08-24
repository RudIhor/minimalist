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
            ->addColumn('title', 'string', ['limit' => 255, ])
            ->addColumn('chat_id', 'biginteger')
            ->addColumn('index', 'smallinteger', ['default' => null])
            ->addColumn('date', 'datetime')
            ->addColumn('is_completed', 'boolean', ['default' => false])
            ->addColumn('created_at', 'datetime')
            ->addColumn('completed_at', 'datetime')
            ->addColumn('updated_at', 'datetime')
            ->addColumn('deleted_at', 'datetime')
            ->addForeignKey('chat_id', 'users', 'chat_id', ['delete' => 'cascade'])
            ->save();
        $triggerOnInsert = "CREATE TRIGGER before_insert_tasks BEFORE INSERT ON `tasks` FOR EACH ROW
    BEGIN
        IF NEW.`index` IS NULL THEN
             SET NEW.`index` = (SELECT IFNULL(MAX(`index`), 0) + 1 FROM tasks WHERE chat_id = NEW.chat_id AND date = NEW.`date`); 
        END IF;
    END;
";
        $triggerOnUpdate = "CREATE TRIGGER after_update_tasks BEFORE UPDATE ON `tasks` FOR EACH ROW
    BEGIN
        IF NEW.`index` IS NOT NULL AND NEW.`deleted_at` IS NOT NULL THEN 
            SET NEW.`index` = NULL;
        END IF;
    END;
";

        $this->execute($triggerOnInsert);
        $this->execute($triggerOnUpdate);
    }

    /**
     * @return void
     */
    public function down(): void
    {
        $this->execute('DROP TRIGGER IF EXISTS before_insert_tasks;');
        $this->table('tasks')->drop()->save();
    }
}
