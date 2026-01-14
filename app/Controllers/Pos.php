<?php

namespace App\Controllers;

class Pos extends BaseController
{
    public function mobile()
    {
        // Just serve the HTML file
        $html = file_get_contents(FCPATH . 'pos-mobile.html');
        return $this->response->setBody($html);
    }
}
