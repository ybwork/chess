<?php

namespace components;

use \interfaces\paginators\IPaginator;

class Paginator
{
    private $paginator;

    /**
     * Sets implementing for IPaginator interface
     *
     * @param IPaginator $paginator - object implementing IPaginator
     */
    public function set_paginator(IPaginator $paginator)
    {
        $this->paginator = $paginator;
    }

    /**
     * @param $total - number of all tasks
     * @param $current_page_number - number current page
     * @param $limit - number tasks for each page
     * @param $index - url name for pagination pages
     * @return result of the function set_params 
     */
    public function set_params($total, $current_page_number, $limit, $index)
    {
        return $this->paginator->set_params($total, $current_page_number, $limit, $index);
    }

    /**
     * Gets full pagination html
     *
     * @return result of the function get
     */
    public function get()
    {
        return $this->paginator->get();
    }

    /**
     * Generates html for pagination
     *
     * @param $page - number page for link
     * @param $text - text for link
     * @return result of the function generate_html
     */
    private function generate_html($page, $text=null)
    {
        return $this->paginator->generate_html();
    }

    /**
     * Sets limits record for this page
     *
     * @return result of the function limits
     */
    private function limits()
    {
        return $this->paginator->limits();
    }

    /**
     * Set current page
     *
     * @param $current_page_number - number page
     * @return result of the function set_current_page
     */
    private function set_current_page($current_page_number)
    {
        return $this->paginator->set_current_page();
    }
    
    /**
     * Return all number pages
     *
     * @return result of the function amount
     */
    private function amount()
    {
        return $this->paginator->amount();
    }
}