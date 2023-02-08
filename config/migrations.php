<?php

return [
    'table_storage' => [
        'table_name' => 'doctrine_migration_versions',
        'version_column_name' => 'version',
        'version_column_length' => 191,
        'executed_at_column_name' => 'executed_at',
        'execution_time_column_name' => 'execution_time',
    ],

    'migrations_paths' => [
        'Migrations' => __DIR__.'/../migrations'
    ],

    'all_or_nothing' => true,
    'transactional' => true,
    'check_database_platform' => true,
    'organize_migrations' => 'none',
    'connection' => null,
    'em' => null,
];

// *** GESTION DES MIGRATIONS GRACE AUX ENTITIES CRÉER *** //
// https://www.doctrine-project.org/projects/doctrine-migrations/en/3.5/reference/generating-migrations.html#generating-migrations
// ./vendor/bin/doctrine-migrations diff => la commande regarde si il y a de nouvelle entity et créer une migration
// ./vendor/bin/doctrine-migrations migrate => migre les changements en BDD