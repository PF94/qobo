<?php
/*
 * SPDX-License-Identifier: AGPL-3.0-only
 */

namespace OpenSB2\Controllers;

use OpenSB2\Framework\Controller;

class MiscController extends Controller {
    public function privacy() {
        return $this->frontend->render("markdown", [
            'page' => 'privacy.md',
        ]);
    }

    public function help() {
        return $this->frontend->render("markdown", [
            'page' => 'help.md',
        ]);
    }

    public function guidelines() {
        return $this->frontend->render("markdown", [
            'page' => 'guidelines.md',
        ]);
    }
}
