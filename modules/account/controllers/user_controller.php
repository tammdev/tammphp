<?php

namespace Tamm\Modules\Account\Controllers;


/**
 * @RestController
 */
class UserController {
    /**
     * @Get("/users")
     */
    public function index() {
        //
    }

    /**
     * @Post("/users")
     */
    public function create($user) {
        //
    }

    /**
     * @Get("/users/{id}")
     */
    public function view($userid) {
        //
    }

    /**
     * @Put("/users/{id}")
     */
    public function update($userid, $data) {
        //
    }

    /**
     * @Delete("/users/{id}")
     */
    public function delete($userid) {
        //
    }


}