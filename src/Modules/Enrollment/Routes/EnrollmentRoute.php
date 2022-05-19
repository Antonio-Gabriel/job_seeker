<?php

use Slim\App;

use SpeackWithUs\Modules\Enrollment\Controllers\{
    ApplyToJobController,
    ApprovedToJobController
};

return function (App $app) {

    $app->get("/apply/{id}/project", [new ApplyToJobController, "handle"]);
    $app->post("/approved", [new ApprovedToJobController, "handle"]);
};
