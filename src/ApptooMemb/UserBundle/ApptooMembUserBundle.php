<?php

namespace ApptooMemb\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ApptooMembUserBundle extends Bundle
{
	public function getParent()
	{
		return 'FOSUserBundle';
	}
}
