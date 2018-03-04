<?php

return [
    'class' => 'common\components\PhpManager',
    'defaultRoles' => ['guest'],
    'itemFile'=>'@common/rbac/items.php',
    'assignmentFile'=>'@common/rbac/assignments.php',
    'ruleFile'=>'@common/rbac/rules.php',
];
