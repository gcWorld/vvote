<?php

Entrust::routeNeedsPermission( 'admin/vote*', 'manage_votes', Redirect::to('/') );