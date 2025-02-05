<?php
/*
 * SPDX-License-Identifier: AGPL-3.0-only
 */

namespace OpenSB2\Framework;

interface Storage {
    public function processVideo($new, $target_file);
    public function processImage($new, $target_file);
    public function processMusic($new, $target_file);
    public function processFlash($new, $target_file);

    public function uploadProfilePicture($temp_name, $new);
}
