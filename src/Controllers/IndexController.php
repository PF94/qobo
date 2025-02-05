<?php
/*
 * SPDX-License-Identifier: AGPL-3.0-only
 */

namespace OpenSB2\Controllers;

use OpenSB2\Framework\Controller;

class IndexController extends Controller {
    public function index() {
        $uploads = $this->db->execute("SELECT * FROM uploads ORDER BY published DESC LIMIT 12");

        return $this->frontend->render("index", [
            'uploads' => $uploads,
        ]);
    }
}
