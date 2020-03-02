<?php

namespace ant\discount\migrations\rbac;

use yii\db\Schema;
use ant\rbac\Migration;
use ant\rbac\Role;

class M200302115549Permissions extends Migration
{
	protected $permissions;
	
	public function init() {
		$this->permissions = [
			\ant\discount\controllers\DefaultController::className() => [
				'apply-coupon' => ['Apply Coupon', [Role::ROLE_GUEST]],
				'remove-coupon' => ['Remove Coupon', [Role::ROLE_GUEST]],
			],
		];
		
		parent::init();
	}
	
	public function up()
    {
		$this->addAllPermissions($this->permissions);
    }

    public function down()
    {
		$this->removeAllPermissions($this->permissions);
    }
}
