<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateFeatureFlagsTable extends AbstractMigration
{
    public function up(): void
    {
        $this->table('feature_flags')
            ->addColumn('name', 'string')
            ->addColumn('value', 'string')
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime')
            ->save();
    }

    public function down(): void
    {
        $this->table('feature_flags')->drop()->save();
    }
}
