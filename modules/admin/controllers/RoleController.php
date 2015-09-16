<?php

namespace app\modules\admin\controllers;

use app\components\AdminBehavior;
use dektrium\rbac\controllers\RoleController as BaseRoleController;

class RoleController extends BaseRoleController
{
    use AdminBehavior;
}
