<?php

namespace components;

use \paginators\IPaginator;

class Paginator
{
    private $paginator;

    public function set_paginator(IPaginator $paginator)
    {
        $this->paginator = $paginator;
    }

    public function get()
    {
        return $this->paginator->get();
    }

    private function generate_html($page, $text=null)
    {
        return $this->paginator->generate_html();
    }

    private function limits()
    {
        return $this->paginator->limits();
    }

    private function set_current_page($current_page_number)
    {
        return $this->paginator->set_current_page();
    }

    private function amount()
    {
        return $this->paginator->amount();
    }
}